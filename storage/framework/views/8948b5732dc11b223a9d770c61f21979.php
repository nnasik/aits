<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table>tr:n-child(even)>td {
            background-color: red;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #0e5390;
            color: #fff;
        }

        .no-border td {
            border: none;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            position: fixed;
            margin: 0;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 12px;
            /* adjust as needed */
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            /* optional line */
        }

        @page {
            margin: 20px 30px 45px 55px;
            /* top, right, bottom, left */
            counter-increment: page;
        }

        .page-number:after {
            content: "Page " counter(page) " of " counter(pages);
        }
    </style>
</head>
<title>AITS Quotation <?php echo e($quotation->reference); ?></title>

<body>

    <header>
        <table class="no-border">
            <tr>
                <td>
                    <img src="assets/images/logo.png" alt="" srcset="" style="height:120px;">
                </td>
                <td class="center" style="vertical-align: top;">
                    <h1 style="margin:0;margin-top:12px;font-size:1.35em">AMERICAN INTERNATIONAL TRAINING SERVICES LLC
                    </h1>
                    <p style="margin:0">
                        Al Nadbah 1<sup>st</sup> Street, Muasaffah M45, Abu Dhabi, UAE<br>
                        Contact : +971 24 479 582 | +971 24 479 004 | +971 55 9147 537<br>
                        Email & Web : sales@blcontrol.com | www.trainingsinusa.com
                    </p>
                </td>
            </tr>
        </table>
    </header>




    <div>
        <h2 class="center" style="margin: 0;color:#0e5390">Quotation</h2>
    </div>


    <table class="no-border">
        <tr>
            <td>
                <div class="bold">Quote To :</div>
                <?php echo e($quotation->company_name); ?><br>
                <?php echo e($quotation->company_address); ?><br>
                <?php echo e($quotation->company_phone); ?><br>
                <?php echo e($quotation->company_email); ?><br><br>

                <b>Attn : </b><?php echo e($quotation->quote_for); ?>

            </td>
            <td class="right">
                <div><b>Quote (Ref) # :</b> <?php echo e($quotation->reference); ?></div>
                <div><b>Rev :</b> <?php echo e(str_pad($quotation->revision, 2, '0', STR_PAD_LEFT)); ?></div>
                <div><b>Date :</b> <?php echo e($quotation->date); ?></div>
                <div><b>Valid Until :</b> <?php echo e($quotation->valid_until); ?></div>
            </td>
        </tr>
    </table>

    <br>
    <?php
    $i=1;
    $colsplan = 4;
    $hasDiscount = $quotation->rows()->where('discount', '>', 0)->exists();
    if($hasDiscount){
    $cosplan = 5;
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <?php if($hasDiscount): ?>
                <th>Discount</th>
                <?php endif; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            <?php $__currentLoopData = $quotation->rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="center"><?php echo e($i); ?></td>
                <td>Training and Certificates for : <b><?php echo e($row->training_name); ?></b>
                    <br>
                    <i>Training Delivery : <?php echo e($row->delivery_mode); ?></i>,
                    <i>Duration : <?php echo e($row->duration); ?></i>
                </td>
                <td class="center"><?php echo e($row->qty); ?></td>
                <td class="right">AED <?php echo e(number_format($row->unit_price, 2)); ?></td>
                <?php if($hasDiscount): ?>
                <td class="right">AED <?php echo e(number_format($row->discount, 2)); ?></td>
                <?php endif; ?>
                <td class="right">AED <?php echo e(number_format($row->total, 2)); ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot class="right">
            <tr>
                <td colspan="<?php echo e($colsplan); ?>">Sub Total :</td>
                <td>AED <?php echo e(number_format($quotation->sub_total, 2)); ?></td>
            </tr>

            <tr>
                <td colspan="<?php echo e($colsplan); ?>">Discount :</td>
                <td>AED <?php echo e(number_format($quotation->discount, 2)); ?></td>
            </tr>
            <tr>
                <td colspan="<?php echo e($colsplan); ?>">VAT (5%) :</td>
                <td>AED <?php echo e(number_format($quotation->vat, 2)); ?></td>
            </tr>
            <tr>
                <td colspan="<?php echo e($colsplan); ?>"><b>Grand Total :</b></td>
                <td><b>AED <?php echo e(number_format($quotation->grand_total, 2)); ?></b></td>
            </tr>
        </tfoot>
    </table>

    <br>

    <b>Prepared By :</b> <?php echo e($quotation->prepared_by_name); ?><br>
    <b>Email :</b> <?php echo e($quotation->prepared_by_email); ?><br>
    <b>Phone :</b> <?php echo e($quotation->prepared_by_contact); ?>


    <br>
    <br>
    <?php if($quotation->text_1): ?>
    <h3><?php echo e($quotation->text_1); ?></h3>
    <br>
    <?php endif; ?>

    
    <?php if($quotation->text_2): ?>
    <p style="text-align:justify;"><?php echo e($quotation->text_2); ?></p>
    <br>
    <?php endif; ?>
    
    <?php if($quotation->text_3): ?>
    <p style="text-align:justify;"><?php echo e($quotation->text_3); ?></p>
    <br>
    <?php endif; ?>

    <?php if($quotation->text_4): ?>
    <p style="text-align:justify;"><?php echo e($quotation->text_4); ?></p>
    <br>
    <?php endif; ?>

    <?php if($quotation->text_5): ?>
    <p style="text-align:justify;"><?php echo e($quotation->text_5); ?></p>
    <br>
    <?php endif; ?>
    

    
    
    
    <br>
    <p><i>We would be pleased to provide any additional information required and appreciate the opportunity to support
            your
            requirements.</i></p>

    <footer class="footer">
        <table class="table no-border">
            <tr>
                <td style="width: 25%;"><i>Doc No : QHSE/FS-AITS-CQ-001</i></td>
                <td class="center" style="width: 25%;"><i>REV : 00</i></td>
                <td class="right" style="width: 25%;"><i>Date : 2025-12-16</i></td>
                <td class="right" style="width: 25%;"></td>
            </tr>
        </table>
    </footer>
    <style>
        /* Remove top and bottom margins for all elements */
        h1, h2, h3, h4, h5, h6, p, ul, li {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>

    
    <?php if($quotation->terms_and_conditions): ?>
    <div style="page-break-before: always;"></div>

    <?php echo nl2br($quotation->terms_and_conditions->content); ?>


    <?php endif; ?>




</body>

</html><?php /**PATH D:\xampp\htdocs\aits\resources\views/quotations/templates/00.blade.php ENDPATH**/ ?>