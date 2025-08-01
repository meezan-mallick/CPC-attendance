<?php

namespace App\Libraries;

use TCPDF;

class MyPdf extends TCPDF
{
    // Public properties to store dynamic data
    public $user_full_name = 'N/A';
    public $coordinator_name = 'Not Assigned';

    // Setter method to pass data from the controller
    public function setCustomFooterData($user_full_name, $coordinator_name)
    {
        $this->user_full_name = $user_full_name;
        $this->coordinator_name = $coordinator_name;
    }

    // Page header (no changes needed)
    public function Header()
    {
        $headerHtml = ' 
        <table cellpadding="5" border="0" style="width:100%;">
            <tr>
                <td style="text-align: center; font-size:16px; font-weight:bold;">CENTRE FOR PROFESSIONAL COURSES</td>
            </tr>
            <tr>
                <td style="text-align: center; font-size:16px; font-weight:bold;">GUJARAT UNIVERSITY</td>
            </tr>
            <tr>
                <td style="text-align: center;">Maharshi Aryabhatt Building, Gujarat University, Ahmedabad - 380009</td>
            </tr>
        </table>
        
        <div style="padding-top: 15px;padding-bottom: 15px;" width="100%">
            <hr >
        </div>
        <table width="100%">
            <tr>
                <td align="right"><strong>Date:</strong> ' . date("d-m-Y") . '</td>
            </tr>
        </table>
        <h3 style="padding-top: 15px;padding-bottom: 15px;text-align: center; text-decoration: underline;">PAYMENT VOUCHER</h3>
        ';

        $this->writeHTMLCell(0, 0, '', '', $headerHtml, 0, 1, 0, true, 'L', true);
    }

    // Page footer (now contains the repeating signature block)
    // app/Libraries/MyPdf.php

public function Footer()
{
    // Position for the signature block (e.g., 35mm from the bottom)
    $this->SetY(-35); 
    
    // HTML for the signature block
    $footerHtml = '
        <table width="100%">
            <tr>
                <td style="text-align: center;">________________________<br><b>Resource Person</b><br>' . esc($this->user_full_name ?? 'N/A') . '</td>
                <td style="text-align: center;">________________________<br><b>Program Incharge</b> <br> ' . esc($this->coordinator_name ?? 'N/A') . '</td>
                <td style="text-align: center;">________________________<br><b>Director</b><br>Dr Paavan Pandit</td>
            </tr>
        </table>';

    // Render the signature block HTML
    $this->writeHTMLCell(0, 0, '', '', $footerHtml, 0, 1, 0, true, 'L', true);

    // Position for the page number (e.g., 15mm from the bottom, so it is below the signature block)
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);

    // Render the page number
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
}
}