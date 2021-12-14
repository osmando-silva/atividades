<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once __DIR__ . '/vendor/autoload.php';

class Mpdf_Library {

    function pdf($dados_impressao, $caminhoDoArquivo, $orientacao, $css, $rodape, $cabecalho){
        
        $mpdf = new \Mpdf\Mpdf([
                                'default_font_size' => 8
                              ]);
        
        $mpdf->_setPageSize('A4', $orientacao);
        
        $mpdf->AddPageByArray(array('orientation'=>"$orientacao", 'margin-top'=>10, 'margin-left'=>10, 'margin-right'=>10, 'margin-bottom'=>10, 'margin-footer'=>5));
        
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->packTableData = true;
        $mpdf->allow_html_optional_endtags = false;
        $mpdf->FontSize = 10;
        
        if ($cabecalho != ''){
            
            $mpdf->defaultheaderfontsize = 10;
            $mpdf->defaultheaderfontstyle = 'B';
            $mpdf->defaultheaderline = 0;
            @$mpdf->SetHeader($cabecalho);
            
        }
        
        if ($rodape != ''){
            
            $mpdf->defaultfooterfontsize = 6;
            $mpdf->defaultfooterfontstyle = 'B';
            $mpdf->defaultfooterline = 1;
            @$mpdf->SetFooter($rodape);
            
        }
        
        if ($css){
            
            $stylesheet = file_get_contents("css/$css.css");
            
        }else{
            
            $stylesheet = file_get_contents("css/mpdf.css");
            
        }
        
        @$mpdf->WriteHTML($stylesheet,1);
        
        @$mpdf->WriteHTML($dados_impressao, 2);
        
        @$mpdf->Output($caminhoDoArquivo);
        
        return;
    }

}