<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IBA Karachi - Meal Voucher</title>
<style type="text/css">
.table2 td {
    border-bottom:1px solid #000;
    padding:5px;
    font-size: 12px;
}
.voucher-copy {
    width:25%; 
    border:1px solid #000;
    page-break-inside: avoid;
}
.copy-label {
    margin-top:20px; 
    font-weight:bold; 
    text-align:center; 
    height: 100px; 
    vertical-align: bottom;
    border:none;
}
</style>
<style type="text/css" media="print">
    @page {
        size: landscape;
        margin: 3mm;
    }
    .no-print {
        display: none;
    }
    body {
        -webkit-print-color-adjust: exact;
    }
</style>
</head>
<body onload="window.print()">
    
<table style="width:1200px;border:1px solid #000;">
  <tr>
    <!-- Student Copy -->
    <td class="voucher-copy">
        <table style="width:100%;" class="table2">
            <tr>
                 <td  style="border:none;">
                    <img src="{{ asset('voucher/iba-logo-voucher.jpg') }}" width="170" alt="IBA" align="left" />
                </td>
                <td  style="border:none;">
                    <img src="{{ asset('voucher/meezan-logo-voucher.jpg') }}" width="50" alt="bank" align="right" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; height:50px; font-size: 20px; vertical-align:top;">
                    <strong>Fee Voucher</strong>
                </td>
            </tr>
            <tr>
                <td style="width:40%; font-weight:bold;">Customer Code:</td>
                <td style="font-weight:bold;">IBA</td>
            </tr>
            <tr>
                <td style="width:40%;">Voucher No:</td>
                <td style="font-weight:bold;">{{ $voucher_data['uid'] }}</td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td style="font-weight:bold;">{{ $student->name }}</td>
            </tr>
            <tr>
                <td>Fee Amount</td>
                <td style="font-weight:bold;">Rs. {{ number_format($voucher_data['total_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td style="font-weight:bold;">Mess Charges</td>
            </tr>
            <!-- Instructions -->
            <tr>
                <td colspan="2" style="height:120px; vertical-align:top;border:none; padding-top:10px;">
                    <strong>INSTRUCTIONS:</strong>
                    <ol style="padding-left: 15px; margin-top:5px;">
                        <li>Fee will not be accepted after {{ \Carbon\Carbon::parse($voucher_data['end_date'])->format('d-M-Y') }}.</li>
                        <li>Fee voucher can only be deposit through cash payment.</li>
                        <li>Fee paid is non refundable and non transferable.</li>
                        <li>Only amount specified in the fee voucher is Acceptable at the bank. Altered fee voucher is not acceptable for payment of Fee </li>
                        <li>For Bank related queries please contact Mr. Noman Ali Khan (0304-0922401)</li>
                    </ol>
                </td>
            </tr>
            
            <!-- Signature Lines -->
            <tr>
                <td style="border:none; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Officer</small>
                </td>
                <td style="border:none; text-align:right; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Cashier</small>
                </td>
            </tr>
            
            <!-- Copy Label -->
            <tr>
                <td colspan="2" class="copy-label">Student Copy</td>
            </tr>
        </table>
    </td>
    
    <!-- Cafeteria Copy -->
    <td class="voucher-copy">
        <table style="width:100%;" class="table2">
            <tr>
                 <td  style="border:none;">
                    <img src="{{ asset('voucher/iba-logo-voucher.jpg') }}" width="170" alt="IBA" align="left" />
                </td>
                <td  style="border:none;">
                    <img src="{{ asset('voucher/meezan-logo-voucher.jpg') }}" width="50" alt="bank" align="right" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; height:50px; font-size: 20px; vertical-align:top;">
                    <strong>Fee Voucher</strong>
                </td>
            </tr>
            <tr>
                <td style="width:40%; font-weight:bold;">Customer Code:</td>
                <td style="font-weight:bold;">IBA</td>
            </tr>
            <tr>
                <td style="width:40%;">Voucher No:</td>
                <td style="font-weight:bold;">{{ $voucher_data['uid'] }}</td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td style="font-weight:bold;">{{ $student->name }}</td>
            </tr>
            <tr>
                <td>Fee Amount</td>
                <td style="font-weight:bold;">Rs. {{ number_format($voucher_data['total_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td style="font-weight:bold;">Mess Charges</td>
            </tr>
            <!-- Instructions -->
            <tr>
                <td colspan="2" style="height:120px; vertical-align:top;border:none; padding-top:10px;">
                    <strong>INSTRUCTIONS:</strong>
                    <ol style="padding-left: 15px; margin-top:5px;">
                        <li>Fee will not be accepted after {{ \Carbon\Carbon::parse($voucher_data['end_date'])->format('d-M-Y') }}.</li>
                        <li>Fee voucher can only be deposit through cash payment.</li>
                        <li>Fee paid is non refundable and non transferable.</li>
                        <li>Only amount specified in the fee voucher is Acceptable at the bank. Altered fee voucher is not acceptable for payment of Fee </li>
                        <li>For Bank related queries please contact Mr. Noman Ali Khan (0304-0922401)</li>
                    </ol>
                </td>
            </tr>
            
            <!-- Signature Lines -->
            <tr>
                <td style="border:none; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Officer</small>
                </td>
                <td style="border:none; text-align:right; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Cashier</small>
                </td>
            </tr>
            
            <!-- Copy Label -->
            <tr>
                <td colspan="2" class="copy-label">Hostel Copy</td>
            </tr>
        </table>
    </td>
    
    <!-- Accounts Copy -->
    <td class="voucher-copy">
        <table style="width:100%;" class="table2">
            <tr>
                 <td  style="border:none;">
                    <img src="{{ asset('voucher/iba-logo-voucher.jpg') }}" width="170" alt="IBA" align="left" />
                </td>
                <td  style="border:none;">
                    <img src="{{ asset('voucher/meezan-logo-voucher.jpg') }}" width="50" alt="bank" align="right" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; height:50px; font-size: 20px; vertical-align:top;">
                    <strong>Fee Voucher</strong>
                </td>
            </tr>
            <tr>
                <td style="width:40%; font-weight:bold;">Customer Code:</td>
                <td style="font-weight:bold;">IBA</td>
            </tr>
            <tr>
                <td style="width:40%;">Voucher No:</td>
                <td style="font-weight:bold;">{{ $voucher_data['uid'] }}</td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td style="font-weight:bold;">{{ $student->name }}</td>
            </tr>
            <tr>
                <td>Fee Amount</td>
                <td style="font-weight:bold;">Rs. {{ number_format($voucher_data['total_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td style="font-weight:bold;">Mess Charges</td>
            </tr>
            <!-- Instructions -->
            <tr>
                <td colspan="2" style="height:120px; vertical-align:top;border:none; padding-top:10px;">
                    <strong>INSTRUCTIONS:</strong>
                    <ol style="padding-left: 15px; margin-top:5px;">
                        <li>Fee will not be accepted after {{ \Carbon\Carbon::parse($voucher_data['end_date'])->format('d-M-Y') }}.</li>
                        <li>Fee voucher can only be deposit through cash payment.</li>
                        <li>Fee paid is non refundable and non transferable.</li>
                        <li>Only amount specified in the fee voucher is Acceptable at the bank. Altered fee voucher is not acceptable for payment of Fee </li>
                        <li>For Bank related queries please contact Mr. Noman Ali Khan (0304-0922401)</li>
                    </ol>
                </td>
            </tr>
            
            <!-- Signature Lines -->
            <tr>
                <td style="border:none; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Officer</small>
                </td>
                <td style="border:none; text-align:right; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Cashier</small>
                </td>
            </tr>
            
            <!-- Copy Label -->
            <tr>
                <td colspan="2" class="copy-label">Bank Copy</td>
            </tr>
        </table>
    </td>
    
    <!-- Record Copy -->
    <td class="voucher-copy">
        <table style="width:100%;" class="table2">
            <tr>
                 <td  style="border:none;">
                    <img src="{{ asset('voucher/iba-logo-voucher.jpg') }}" width="170" alt="IBA" align="left" />
                </td>
                <td  style="border:none;">
                    <img src="{{ asset('voucher/meezan-logo-voucher.jpg') }}" width="50" alt="bank" align="right" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; height:50px; font-size: 20px; vertical-align:top;">
                    <strong>Fee Voucher</strong>
                </td>
            </tr>
            <tr>
                <td style="width:40%; font-weight:bold;">Customer Code:</td>
                <td style="font-weight:bold;">IBA</td>
            </tr>
            <tr>
                <td style="width:40%;">Voucher No:</td>
                <td style="font-weight:bold;">{{ $voucher_data['uid'] }}</td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td style="font-weight:bold;">{{ $student->name }}</td>
            </tr>
            <tr>
                <td>Fee Amount</td>
                <td style="font-weight:bold;">Rs. {{ number_format($voucher_data['total_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>Description</td>
                <td style="font-weight:bold;">Mess Charges</td>
            </tr>
            <!-- Instructions -->
            <tr>
                <td colspan="2" style="height:120px; vertical-align:top;border:none; padding-top:10px;">
                    <strong>INSTRUCTIONS:</strong>
                    <ol style="padding-left: 15px; margin-top:5px;">
                        <li>Fee will not be accepted after {{ \Carbon\Carbon::parse($voucher_data['end_date'])->format('d-M-Y') }}.</li>
                        <li>Fee voucher can only be deposit through cash payment.</li>
                        <li>Fee paid is non refundable and non transferable.</li>
                        <li>Only amount specified in the fee voucher is Acceptable at the bank. Altered fee voucher is not acceptable for payment of Fee </li>
                        <li>For Bank related queries please contact Mr. Noman Ali Khan (0304-0922401)</li>
                    </ol>
                </td>
            </tr>
            
            <!-- Signature Lines -->
            <tr>
                <td style="border:none; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Officer</small>
                </td>
                <td style="border:none; text-align:right; padding-top:20px;">
                    _________________________<br>
                    <small>Sign Cashier</small>
                </td>
            </tr>
            
            <!-- Copy Label -->
            <tr>
                <td colspan="2" class="copy-label">Finance Copy</td>
            </tr>
        </table>
    </td>
  </tr>
</table>

<div class="no-print" style="text-align:center; margin-top:20px; padding:20px;">
    <button onclick="window.print()" style="padding:10px 20px; background:#4CAF50; color:white; border:none; border-radius:4px; cursor:pointer; margin-right:10px;">
        <i class="fas fa-print"></i> Print Voucher
    </button>
    <button onclick="window.close()" style="padding:10px 20px; background:#f44336; color:white; border:none; border-radius:4px; cursor:pointer;">
        <i class="fas fa-times"></i> Close Window
    </button>
</div>

<!-- Include Font Awesome for icons if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>