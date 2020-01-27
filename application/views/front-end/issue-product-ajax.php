<div class="box-body">
    <div class="table-responsive">
        <table class="table no-margin">
            <thead>
            <tr>

                <th style="border:1px solid #dee2e6">Product Name</th>
                <th style="border:1px solid #dee2e6">Size <span style="font-size: 11px;color:#e11616;">(inches/liter/kg)</span></th>
                <th style="border:1px solid #dee2e6">Issuer Name</th>
                <th style="border:1px solid #dee2e6">Issuer To</th>
                <th style="border:1px solid #dee2e6">Quantity</th>
                <th style="border:1px solid #dee2e6">Issue Date</th>
            </tr>
            </thead>
            <tbody>
            <?php if( ! empty($products)) { ?>

                <?php foreach($products as $product){

                    ?>
                    <tr>
                        <td style="border:1px solid #dee2e6"><?php echo $product['product_name'] ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product['size']  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product['issuer_name']  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product['issue_type']  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product['latest_quantity']  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product['issue_date']  ?></td>
                    </tr>

                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="8" class="no-records">No records</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="box-footer" style="margin-top:20px;">
    <ul class="pagination">
        <?php echo $pagelinks ?>
    </ul>
</div>
