<?php
//require '../etms/authentication.php'; // admin authentication check 
require '../etms/classes/admin_class.php';
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$admin_class = new admin_class();

$employee_id = $_GET['employee_id'];
$payroll_id = $_GET['payroll_id'];

$sql = "SELECT p.*, a.fullname AS employee_name, pr.start_date, pr.end_date
        FROM payslip p
        JOIN tbl_admin a ON p.employee_id = a.user_id
        JOIN payroll_list pr ON p.payroll_id = pr.id
        WHERE p.payroll_id = :payroll_id AND p.employee_id = :employee_id LIMIT 1";

$stmt = $admin_class->db->prepare($sql);
$stmt->bindParam(':payroll_id', $payroll_id);
$stmt->bindParam(':employee_id', $employee_id);
$stmt->execute();
$payslipDetails = $stmt->fetch(PDO::FETCH_ASSOC);

// initialize dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// convert payslip_header.png to base64
$pngbase64 = base64_encode(file_get_contents('../assets/images/payslip/payslip_header.png'));

// data arrays --- with placeholder values for now
$salaryComponents = [
    ['component' => 'Monthly Basic Salary', 'amount' => $payslipDetails['monthly_pay'] ?? '0.00'],
    ['component' => 'Basic Pay', 'amount' => $payslipDetails['basic_pay'] ?? '0.00'],
    ['component' => 'De Minimis Allowance', 'amount' => $payslipDetails['deminimis_allowance'] ?? '0.00'],
    ['component' => 'Overtime Pay', 'amount' => $payslipDetails['overtime_pay'] ?? '0.00'],      
    ['component' => 'Rest Day Duty', 'amount' => $payslipDetails['rest_day_pay'] ?? '0.00'],
    ['component' => 'Night Differential', 'amount' => $payslipDetails['night_pay'] ?? '0.00'],
    ['component' => 'Legal Holiday Pay', 'amount' => $payslipDetails['legal_holiday_pay'] ?? '0.00'],
    ['component' => 'Special holiday Pay', 'amount' => $payslipDetails['special_holiday_pay'] ?? '0.00'],
    ['component' => 'Adjustments', 'amount' => $payslipDetails['adjustments'] ?? '0.00'],
    // adding space
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => '&nbsp;', 'amount' => '&nbsp;'],
    ['component' => 'Gross Basic Pay', 'amount' => $payslipDetails['gross_pay'] ?? '0.00']
];

$deductions = [
    ['deduction' => 'SSS Contribution', 'amount' => $payslipDetails['sss_ee'] ?? '0.00'],
    ['deduction' => 'Phil-Health Contribution', 'amount' => $payslipDetails['phic_ee'] ?? '0.00'],
    ['deduction' => 'Pag-IBIG Contribution', 'amount' => $payslipDetails['pag_ibig_ee'] ?? '0.00'],
    ['deduction' => 'Withholding Tax', 'amount' => '0.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],       // space
    ['deduction' => 'SSS Loan', 'amount' => '0.00'],
    ['deduction' => 'Pag-IBIG Loan', 'amount' => '0.00'],
    ['deduction' => 'Pag-IBIG MP2', 'amount' => '0.00'],
    ['deduction' => 'Vault Loan', 'amount' => '0.00'],
    ['deduction' => 'Overpayments', 'amount' => '0.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],    // space
    ['deduction' => 'Tardiness/Half-Day/Undertime', 'amount' => $payslipDetails['late_deduct'] ?? '0.00'],
    ['deduction' => 'Absence', 'amount' => $payslipDetails['absent_deduct'] ?? '0.00'],
    ['deduction' => '&nbsp;', 'amount' => '&nbsp;'],    // space
    ['deduction' => 'Total Deductions', 'amount' => $payslipDetails['total_deductions'] ?? '0.00']
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
            <td>' . $payslipDetails['employee_id'] . '</td>
            <td class="subtitle">PAY DATE:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="subtitle">EMPLOYEE NAME:</td>
            <td>' . $payslipDetails['employee_name'] . '</td>
            <td class="subtitle">PAY PERIOD:</td>
            <td>' . date('M d', strtotime($payslipDetails['start_date'])) . '-' . date('M d, Y', strtotime($payslipDetails['end_date'])) . '</td>
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
                <td colspan="2">' . $payslipDetails['total_pay'] . '</td>
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
