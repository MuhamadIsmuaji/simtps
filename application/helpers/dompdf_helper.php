<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    function pdf_create($html, $filename='', $paper, $orientation, $stream=TRUE) {
        require_once("dompdf/dompdf_config.inc.php");

        $dompdf = new DOMPDF();
        $dompdf->set_paper($paper,$orientation);
        $dompdf->load_html($html);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename.".pdf",array('Attachment' => 0));
            //$dompdf->stream($filename.".pdf");
        } else {
            return $dompdf->output();
        }
    }

    function pdf_create_point($html, $filename='', $paper, $orientation, $stream=TRUE) {
        require_once("dompdf/dompdf_config.inc.php");

        $dompdf = new DOMPDF();
        $dompdf->set_paper($paper,$orientation);
        $dompdf->load_html($html);
        $dompdf->render();
        if ($stream) {
            $canvas = $dompdf->get_canvas();
            $font = Font_Metrics::get_font("helvetica", "bold");
            // get height and width of page
            $canvas->page_text(500, 20, "Halaman : {PAGE_NUM} dari {PAGE_COUNT}", $font, 6, array(0,0,0));
            $dompdf->stream($filename.".pdf",array('Attachment' => 0));
            //$dompdf->stream($filename.".pdf");
        } else {
            return $dompdf->output();
        }
    }
?>