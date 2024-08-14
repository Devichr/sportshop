<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserFavouriteSportModel;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class AuthController extends BaseController
{
    protected $userModel;
    protected $sportModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['url', 'form']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    

    public function login_process()
    {
        $session = session();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Mengambil data pengguna berdasarkan username
        $user = $this->userModel->get_user_by_username($username);

        // Verifikasi password dan validasi pengguna
        if ($user && password_verify($password, $user['password'])) {
            $session->set('isLoggedIn', true);
            $session->set('user_id', $user['id']);
            $session->set('role', $user['role']);

            // Ambil URL yang ingin dikunjungi setelah login
        $redirectUrl = $session->get('redirect_url') ?? '/';
        $session->remove('redirect_url'); // Hapus setelah digunakan

        // Redirect berdasarkan role pengguna
        if ($user['role'] == 'admin') {
            return redirect()->to('/admin');
        } elseif($user['role'] == 'owner') {
            return redirect()->to('/owner');
        }else {
            return redirect()->to($redirectUrl);
        }
    } else {
        $session->setFlashdata('error', 'Invalid username or password');
        return redirect()->to('/login');
    }
    }
    
    public function sendOTP($email, $otp){
        $emailService = \Config\Services::email();
        $emailService->setFrom('devianochristian@gmail.com', 'Sportshop');
        $emailService->setTo($email);
        $emailService->setSubject('Your OTP Code');
        $emailService->setMessage("Your OTP code is: $otp");

        if ($emailService->send()) {
            return true;
        } else {
            // Log error if email fails to send
            log_message('error', 'Failed to send OTP email: ' . $emailService->printDebugger(['headers']));
            return false;
        }

    }

    public function register_process()
    {

        $userModel = new UserModel();
        $sportModel = new UserFavouriteSportModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role' => 'guest', // default role
            'email' => $this->request->getPost('email'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'otp' => rand(100000, 999999),
            'is_active' => 0 // Jika sudah berhasil registrasi berubah jadi 1
        ];

         // Simpan pengguna
         $userId = $userModel->insert($data);
         
         // Favourite sports array
         $favouriteSports = $this->request->getPost('favourite_sport');
         

         if (!empty($favouriteSports)) {
             foreach ($favouriteSports as $sport) {
                 $sportData = [
                     'user_id' => $userId,
                     'sport' => $sport
                 ];
                 $sportModel->insert($sportData);
             }
         }

                    
         // Kirim OTP melalui email
         if ($this->sendOtp($data['email'], $data['otp'])) {
            session()->set('user_id', $userId);
            return redirect()->to('/verify-otp');
        } else {
            // Jika gagal mengirim email, hapus pengguna
            $userModel->delete($userId);
            return redirect()->to('/register')->with('error', 'Failed to send OTP. Please try again.');
        }
    }
    public function verifyOtp()
    {
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        if ($this->request->getMethod() == 'POST') {
            $inputOtp = $this->request->getPost('otp');
            $userId = session()->get('user_id');   
            $user = $this->userModel->find($userId);
    
            log_message('error', 'User OTP: ' . $user['otp']);
            log_message('error', 'Input OTP: ' . $inputOtp);
    
            if ($user['otp'] = $inputOtp) {
                // Clear OTP and activate user
                $this->userModel->update($userId, ['otp' => null, 'is_active' => 1]);
    
                // Clear the session user_id
                session()->remove('user_id');
    
                // Redirect to login page
                return redirect()->to('/login')->with('success', 'Your account has been activated. Please log in.');
            }
        } else {
            $userId = session()->get('user_id');
            if (!$userId) {
                return redirect()->to('/register')->with('error', 'Session expired, please register again.');
            } else {
                return view('verify_otp');
            }
        }
    }
    

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
