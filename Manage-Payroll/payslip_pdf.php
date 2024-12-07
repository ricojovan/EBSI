<?php

require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// initialize dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// convert payslip_header.png to base64
$pngbase64 = base64_encode(file_get_contents('../assets/images/payslip/payslip_header.png'));

// data arrays --- with placeholder values for now
$salaryComponents = [
    ['component' => 'Monthly Basic Salary', 'amount' => '1000.00'],
    ['component' => 'Basic Pay', 'amount' => '200.00'],
    ['component' => 'De Minimis Allowance', 'amount' => '500.00'],
    ['component' => 'Overtime Pay', 'amount' => '500.00'],      
    ['component' => 'Rest Day Duty', 'amount' => '500.00'],
    ['component' => 'Night Differential', 'amount' => '500.00'],
    ['component' => 'Legal Holiday Pay', 'amount' => '500.00'],
    ['component' => 'Special holiday Pay', 'amount' => '500.00'],
    ['component' => 'Adjustments', 'amount' => '500.00'],
    // adding space
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => 'Gross Basic Pay', 'amount' => '4,700.00']
];

$deductions = [
    ['deduction' => 'SSS Contribution', 'amount' => '1000.00'],
    ['deduction' => 'Phil-Health Contribution', 'amount' => '250.00'],
    ['deduction' => 'Pag-IBIG Contribution', 'amount' => '100.00'],
    ['deduction' => 'Withholding Tax', 'amount' => '100.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],       // space
    ['deduction' => 'SSS Loan', 'amount' => '100.00'],
    ['deduction' => 'Pag-IBIG Loan', 'amount' => '100.00'],
    ['deduction' => 'Pag-IBIG MP2', 'amount' => '100.00'],
    ['deduction' => 'Vault Loan', 'amount' => '100.00'],
    ['deduction' => 'Overpayments', 'amount' => '100.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],    // space
    ['deduction' => 'Tardiness/Half-Day/Undertime', 'amount' => '100.00'],
    ['deduction' => 'Absence', 'amount' => '100.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],    // space
    ['deduction' => 'Total Deductions', 'amount' => '2,150.00']
];

// helper func to generate table rows
function generateTableRows($data, $type = 'salary') {
    $rows = '';
    foreach ($data as $item) {
        if ($type === 'salary') {
            $componentClass = ($item['component'] === '&nbsp;') ? 'no-border' : 'subtitle-2';
            $amountClass = ($item['amount'] === '&nbsp;') ? 'no-border' : '';
            $rows .= '
                <tr>
                    <td colspan="2" class="' . $componentClass . '">' . $item['component'] . '</td>
                    <td colspan="2" class="' . $amountClass . '">' . $item['amount'] . '</td>
                </tr>
            ';
        } else {
            $deductionClass = ($item['deduction'] === '&nbsp;') ? 'no-border' : 'subtitle-2';
            $amountClass = ($item['amount'] === '&nbsp;') ? 'no-border' : '';
            $rows .= '
                <tr>
                    <td colspan="2" class="' . $deductionClass . '">' . $item['deduction'] . '</td>
                    <td colspan="2" class="' . $amountClass . '">' . $item['amount'] . '</td>
                </tr>
            ';
        }
    }
    return $rows;
}


// html layout for the pdf to be generated
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 1px;
            text-align: center;
        }
        .title {
            border: 1px solid black;
            background-color: #0F6295;
            color: white;
        }
        .subtitle {
            border: 0px;
            font-weight: bold;
            text-align:right;
        }
        .subtitle-2 {
            border: 0px;
            text-align:left;
        }   
        .no-border {
            padding:2px;
            border: 0px;
        }
        .underline {
            display: inline-block;
            width: 100%; 
            border-bottom: 1px solid #000; 
        }
    </style>
</head>
<body>
    <div style="text-align: center; padding-top: 0px">
        <img src="data:image/png;base64,' . $pngbase64 . '" style="width: 80%; height: 100px;">
    </div>
    <table class="summary">
        <tr class="title">
            <th colspan="4">PAYSLIP SUMMARY</th>
        </tr>
        
        <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
        
        <tr>
            <td class="subtitle">EMPLOYEE NUMBER:</td>
            <td>EBSI2424</td>
            <td class="subtitle">PAY DATE:</td>
            <td>June 30, 2024</td>
        </tr>
        <tr>
            <td class="subtitle">EMPLOYEE NAME:</td>
            <td>EmpName</td>
            <td class="subtitle">PAY PERIOD:</td>
            <td>June 05-19, 2024</td>
        </tr>

        <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
        
        <tr>
            <td colspan="2" class="no-border">
                <table>
                    <tr class="title">
                        <th colspan="4">SALARY COMPONENT</th>
                    </tr>
                    <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
                    ' . generateTableRows($salaryComponents, 'salary') . '
                </table>
            </td>
            <td colspan="2" class="no-border">
                <table>
                    <tr class="title">
                        <th colspan="4">DEDUCTIONS</th>
                    </tr>
                    <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
                    ' . generateTableRows($deductions, 'deduction') . '
                </table>
            </td>
        </tr>
            <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
            <tr><td colspan="4" class="title">&nbsp;</td></tr>
            <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
            <tr>
                <td colspan="2" class="no-border" style="font-weight:bold;">Net Take Home Pay</td>
                <td colspan="2">2,550.00</td>
            </tr>
            <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
            <tr><td colspan="4" class="title">&nbsp;</td></tr>
            <tr><td colspan="4" class="no-border">&nbsp;</td></tr>
            <tr>
                <td colspan="2" class="no-border">Prepared By:</td>
                <td colspan="2" class="no-border">
                    <span class="underline">&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="no-border">&nbsp;</td>
                <td colspan="2" class="no-border" style="font-size:10px;">HR Officer</td>
            </tr>
    </table>
</body>
</html>
';

$dompdf->loadHtml($html);

$dompdf->setPaper('US Letter', 'portrait');

$dompdf->render();

$dompdf->stream('payslip.pdf', ['Attachment' => 0]);
?>
