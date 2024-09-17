
<style>
    th, td {
  padding: 5px;
  border:1px solid black;
}

.l1{
    padding-left: 5pt;text-indent: 0pt;text-align: left;
}
@media print{
            #btns{ display:none;}
            @page {margin-top: 10px;}
            html, body {
                padding: 10px;
                margin: 0;

            }
            #pnumber:after{
                counter-increment: page;
                content:"Page " counter(page);
            }
            .page-footer{position: absolute;}

        }

</style>
<table style="border: 1px solid black;" cellspacing="0" cellpadding="1">
<tbody>
    <tr style="height:10pt">
        <td class="c1" colspan="10" bgcolor="#BBD5EC">
            <p class="s1" style="text-indent: 0pt;line-height: 12pt;text-align: center;">Tax Invoice</p>
        </td>
    </tr>
    <tr style="height:12pt">
        <td class="c1" colspan="10" bgcolor="#BBD5EC">
            <p class="s2" style="text-indent: 0pt;line-height: 10pt;text-align: center;">TRN: 100539270700003</p>
        </td>
    </tr>
    {{-- <tr style="height:10pt">
        <td class="c2" colspan="6">
            <p class="s3 l1" style="">Invoice No: EFDS/11/01/0091</p>
        </td>
        <td class="l2" colspan="4">
            <p class="s3" style="">Service Period From: 01/12/23</p>
        </td>
    </tr> --}}
    <tr style="height:10pt">
        <td class="c2" colspan="6">
            <p class="s3" style="">Invoice Date: {{date('d/m/Y')}}</p>
        </td>
        <td class="l2" colspan="4">
            <p class="s3 l1" style="">Service Period: {{$billing_month}}</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td class="c2" colspan="6">
            <p class="s3 l1" style="">Document Currency: AED</p>
        </td>
        <td class="l2" colspan="4">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td class="c2" colspan="6" bgcolor="#BBD5EC">
            <p class="s3 l1" style="">Bill to Party</p>
        </td>
        <td class="l2" colspan="4" bgcolor="#BBD5EC">
            <p class="s3 l1" style="">Ship to Party</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td class="c2" colspan="6">
            <p class="s3 l1" style="">{{$project->name}}</p>
        </td>
        <td class="l2" colspan="4">
            <p class="s3 l1" style="">{{$project->name}}</p>
        </td>
    </tr>
    <tr style="height:19pt">
        <td class="c2" colspan="6">
            <p class="s3" style="padding-left: 5pt;padding-right: 6pt;text-indent: 0pt;text-align: left;">Address: Boulevard Plaza, Tower 2, 7th floor, Downtown Dubai, Dubai, PO Box 126251, UAE</p>
        </td>
        <td class="l2" colspan="4">
            <p class="s3 l1" style="">Address: Boulevard Plaza, Tower 2, 7th floor, Downtown Dubai, Dubai, PO Box 126251, UAE</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td class="c2" colspan="6">
            <p class="s3 l1" style="">TRN: 100596351500003</p>
        </td>
        <td class="l2" colspan="4">
            <p class="s3 l1" style="">TRN: 100596351500003</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td class="h1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="width:30px;padding-top: 5pt;padding-left: 11pt;text-indent: 0pt;text-align: left;">Sr.</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 36pt;text-indent: -10pt;text-align: left;">Product / Service Description</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-top: 5pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">UOM</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-top: 5pt;padding-left: 12pt;text-indent: 0pt;text-align: left;">Qty</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-top: 5pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">Rate</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-top: 5pt;padding-left: 10pt;text-indent: 0pt;text-align: left;">Amount</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 14pt;padding-right: 9pt;text-indent: -4pt;line-height: 12pt;text-align: left;">Taxable Value</p>
        </td>
        <td class="p1" colspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="text-indent: 0pt;line-height: 12pt;text-align: center;">VAT</p>
        </td>
        <td  class="p1" rowspan="2" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 23pt;padding-right: 21pt;text-indent: 6pt;text-align: left;">Total (In AED)</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td  class="p1" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 3pt;padding-right: 3pt;text-indent: 0pt;line-height: 12pt;text-align: center;">Rate</p>
        </td>
        <td  class="p1" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 8pt;text-indent: 0pt;line-height: 12pt;text-align: left;">Amount</p>
        </td>
    </tr>
    @php
        $total_amount = 0;
        $total_vat= 0;
        $grand_total = 0;
        $i=1;
    @endphp
    @foreach($result as $row)
    @if($row->item_amount>0)
    @php
        $total_amount += $row->item_amount;
        $total_vat += $row->item_amount*5/100;
        $grand_total = $total_amount+$total_vat;

    @endphp
    <tr style="height:24pt">
        <td class="h1" width="5">
            <p class="s4" style="">{{$i++}}</p>
        </td>
        <td width="200" class="p1">
            <p class="s4" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">{{$row->item_name}}</p>
        </td>
        <td width="90"  class="p1">
            <p class="s5" style="padding-left: 5pt;padding-right: 6pt;text-indent: 0pt;text-align: left;">{{$row->b_month}}</p>
        </td>
        <td  class="p1">
            <p class="s4" style="padding-right: 4pt;text-indent: 0pt;line-height: 12pt;text-align: right;">{{$row->quantity}}</p>
        </td>
        <td  class="p1">
            <p class="s4" style="padding-right: 4pt;text-indent: 0pt;line-height: 12pt;text-align: right;">{{number_format($row->item_price,2)}}</p>
        </td>
        <td  class="p1">
            <p class="s4" style="padding-right: 4pt;text-indent: 0pt;line-height: 12pt;text-align: right;">{{number_format($row->item_amount,2)}}</p>
        </td>
        <td  class="p1">
            <p class="s5" style="padding-right: 4pt;text-indent: 0pt;line-height: 8pt;text-align: right;">{{number_format($row->item_amount,2)}}</p>
        </td>
        <td  class="p1">
            <p class="s4" style="padding-right: 3pt;text-indent: 0pt;line-height: 12pt;text-align: center;">5%.</p>
        </td>
        <td  class="p1">
            <p class="s5" style="padding-right: 4pt;text-indent: 0pt;line-height: 8pt;text-align: right;">{{number_format($row->item_amount*5/100,2)}}</p>
        </td>
        <td class="p1">
            <p class="s5" style="padding-right: 4pt;text-indent: 0pt;line-height: 8pt;text-align: right;">{{number_format(($row->item_amount*5/100)+$row->item_amount,2)}}</p>
        </td>
    </tr>
    @endif
@endforeach
    <tr style="height:19pt">
        <td style="width:184pt;" class="p1" colspan="3" bgcolor="#BBD5EC">
            <p class="s3" style="text-indent: 0pt;text-align: center;">Total</p>
        </td>
        <td style="width:39pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
        </td>
        <td style="width:32pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
        </td>
        <td style="width:51pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s5" style="padding-left: 5pt;text-indent: 0pt;line-height: 8pt;text-align: left;">{{number_format($total_amount,2)}}</p>
        </td>
        <td style="width:51pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s5" style="padding-right: 4pt;text-indent: 0pt;line-height: 8pt;text-align: right;">{{number_format($total_amount,2)}}</p>
        </td>
        <td style="width:30pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
        </td>
        <td style="width:46pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s5" style="padding-right: 4pt;text-indent: 0pt;line-height: 8pt;text-align: right;">{{number_format($total_vat,2)}}</p>
        </td>
        <td style="width:77pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s6" style="padding-left: 17pt;text-indent: 0pt;line-height: 8pt;text-align: left;">{{number_format($grand_total,2)}}</p>
        </td>
    </tr>
    <tr style="height:19pt">
        <td style="width:357pt;" class="p1" colspan="7" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 2pt;text-indent: 0pt;text-align: center;">Total Invoice Amount in Words</p>
        </td>
        <td style="width:76pt;" class="p1" colspan="2">
            <p class="s3" style="padding-left: 16pt;padding-right: 11pt;text-indent: -4pt;line-height: 12pt;text-align: left;">Total Amount before Tax:</p>
        </td>
        <td style="width:77pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s6" style="padding-left: 20pt;text-indent: 0pt;line-height: 8pt;text-align: left;">{{number_format($grand_total,2)}}</p>
        </td>
    </tr>
    <tr style="height:12pt">
        <td style="width:357pt;" class="p1" colspan="7" rowspan="2">
            <p class="s8" style="text-transform:uppercase;padding: 6pt;padding-left: 5pt;padding-right: 7pt;text-indent: 0pt;text-align: left;">AED: <u>{{App\Helpers\CommonHelper::numToWordsRec($grand_total)}}</u></p>
        </td>
        <td style="width:76pt;" class="p1" colspan="2">
            <p class="s3" style="padding-left: 10pt;text-indent: 0pt;text-align: left;">Add: VAT - 5%</p>
        </td>
        <td style="width:77pt;" class="p1">
            <p class="s6" style="padding-top: 2pt;padding-left: 22pt;text-indent: 0pt;line-height: 8pt;text-align: left;">{{number_format($grand_total*5/100,2)}}</p>
        </td>
    </tr>
    <tr style="height:19pt">
        <td style="width:76pt;" class="p1" colspan="2">
            <p class="s3" style="padding-left: 20pt;padding-right: 11pt;text-indent: -7pt;line-height: 12pt;text-align: left;">Total Amount after Tax:</p>
        </td>
        <td style="width:77pt;" class="p1">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
            <p class="s6" style="padding-left: 17pt;text-indent: 0pt;line-height: 8pt;text-align: left;">{{number_format(($grand_total*5/100)+$grand_total,2)}}</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td style="width:357pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt" colspan="7" rowspan="3" bgcolor="#BBD5EC">
            <p class="s3" style="padding-left: 2pt;padding-right: 2pt;text-indent: 0pt;line-height: 12pt;text-align: center;"># ceritified that the particulars given above are true and correct</p>
        </td>
        <td style="width:153pt;" class="p1" colspan="3">
            <p class="s3" style="padding-left: 43pt;text-indent: 0pt;line-height: 12pt;text-align: left;">For Vendor Name</p>
        </td>
    </tr>
    <tr style="height:46pt">
        <td style="width:153pt;" class="p1" colspan="3">
            <p class="s6" style="padding-left: 9pt;text-indent: 23pt;text-align: left;">Bank Name: RAK BANK Company Name: Express Fast Delivery</p>
            <p class="s6" style="padding-left: 1pt;text-indent: 0pt;line-height: 12pt;text-align: center;">Service</p>
            <p class="s6" style="padding-left: 16pt;padding-right: 15pt;text-indent: 0pt;line-height: 12pt;text-align: center;">Account Number: 0373235629001 IBAN: AE400400000373235629001</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td style="width:153pt;border-top-style:solid;border-top-width:1pt" colspan="3">
            <p class="s3" style="padding-left: 36pt;text-indent: 0pt;line-height: 12pt;text-align: left;">Authorised Signatory</p>
        </td>
    </tr>
    <tr style="height:10pt">
        <td style="width:357pt;border-top-style:solid;border-top-width:1pt" colspan="7">
            <p style="text-indent: 0pt;text-align: left;"><br></p>
        </td>
        <td style="width:153pt" colspan="3" bgcolor="#FFC000">
            <p class="s6" style="padding-left: 28pt;text-indent: 0pt;line-height: 12pt;text-align: left;">### Sign &amp; Stamp Required</p>
        </td>
    </tr>
</tbody>
</table>
<script>
    window.print();
</script>

