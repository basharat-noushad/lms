<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    /**
     * Generate a certificate for a completed enrollment
     */
    public function generate(Enrollment $enrollment): Certificate
    {
        // Check if certificate already exists
        if ($enrollment->certificate) {
            return $enrollment->certificate;
        }

        // Create certificate record
        $certificate = Certificate::create([
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'enrollment_id' => $enrollment->id,
            'certificate_number' => Certificate::generateCertificateNumber(),
            'issued_at' => now(),
        ]);

        // Generate PDF
        $pdfPath = $this->generatePDF($certificate);
        $certificate->update(['pdf_path' => $pdfPath]);

        return $certificate;
    }

    /**
     * Generate PDF certificate
     */
    protected function generatePDF(Certificate $certificate): string
    {
        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'user' => $certificate->user,
            'course' => $certificate->course,
        ]);

        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';
        Storage::put('public/' . $filename, $pdf->output());

        return $filename;
    }

    /**
     * Check if enrollment is eligible for certificate
     */
    public function isEligible(Enrollment $enrollment): bool
    {
        return $enrollment->progress >= 100 && $enrollment->completed_at !== null;
    }

    /**
     * Auto-generate certificate if eligible
     */
    public function autoGenerate(Enrollment $enrollment): ?Certificate
    {
        if ($this->isEligible($enrollment) && !$enrollment->certificate) {
            return $this->generate($enrollment);
        }

        return null;
    }
}
