<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class PdfService
{
    private $pdf;
    private $pdfName;

    //Give the complete full path to the PDF
    public function __construct($pdf = null)
    {
        $this->pdf = $pdf;
    }

    public function checkPdf() {
        return true;
    }

    public function storePdfBase64($pdf) {
        $data = explode(',', $pdf);
        $random = Str::random(40);

        Storage::disk('local')->put(env('STORAGE_PDF') . "/$random.pdf", base64_decode($data[1]));
        $path = storage_path('app/'. env('STORAGE_PDF') .'/' . $random . '.pdf');

        $this->pdf = $path;
        $this->pdfName = $random . '.pdf';

        return $this->pdfName;
    }

    public function splitPdf($page)
    {
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile($this->pdf);
        $tplIdx = $pdf->importPage($page);
        $pdf->useTemplate($tplIdx);
        $pdf->Output($this->pdf, "F");
        $pdf->close();
    }

    public function storeToAws() {
        $file = Storage::disk('local')->get(env('STORAGE_PDF') . '/' . $this->pdfName);
        Storage::disk('s3')->put(env('STORAGE_PDF') . '/' . basename($this->pdf), $file);

        //Delete local storage
        Storage::disk('local')->delete(env('STORAGE_PDF') . '/' . $this->pdfName);
    }
}