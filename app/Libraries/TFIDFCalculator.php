<?php

namespace App\Libraries;

class TFIDFCalculator
{
    // Function to calculate term frequency
    public function calculateTF($term, $document)
    {
        $words = explode(' ', strtolower($document));
        $termCount = array_count_values($words);
        return isset($termCount[$term]) ? $termCount[$term] / count($words) : 0;
    }
    // Function to calculate inverse document frequency
    public function calculateIDF($term, $documents)
    {
        $numDocuments = count($documents);
        $numDocumentsWithTerm = 0;

        foreach ($documents as $document) {
            if (stripos($document, $term) !== false) {
                $numDocumentsWithTerm++;
            }
        }

        return log($numDocuments / ($numDocumentsWithTerm ?: 1));
    }

    // Function to calculate TF-IDF
    public function calculateTFIDF($term, $document, $documents)
    {
        return $this->calculateTF($term, $document) * $this->calculateIDF($term, $documents);
    }
}
