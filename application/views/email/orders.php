<table style="line-height: 15pt">
    <tr style="font-weight: bold">
        <td width="40%">Nama Lengkap</td>
        <td><?= $user->first_name . ' ' . $user->last_name ?></td>
    </tr>
    <tr>
        <td width="40%">Email</td>
        <td><?= $user->email ?></td>
    </tr>
    <tr>
        <td width="40%">Nomor HP</td>
        <td><?= $user->phone ?></td>
    </tr>
</table>
<br>
<table style="border: 1px solid black; width: 100%">
    <thead style="text-align: left">
        <th style="border: 1px solid black;"></th>
        <th style="border: 1px solid black;">Nama Barang</th>
        <th style="border: 1px solid black;">Jumlah</th>
        <th style="border: 1px solid black;">Harga</th>
    </thead>
    <tbody>
    <?php foreach ($order->order_details as $order_detail) { ?>
        <tr>
            <td style="border: 1px solid black; width:20%">
                <div>
                    <a href="<?= site_url('homepage/produk/' . $order_detail->product->slug) ?>">
                        <img alt="<?= $order_detail->product->name ?>"
                             src="<?= base_url('assets/images/products/' . cek_file($order_detail->product->image_1, './assets/images/products/', 'default.png')) ?>"
                             style="max-width: 240px !important; max-height: 240px !important; height: auto !important; width: auto !important;">
                    </a></div>
            </td>
            <td style="border: 1px solid black; width:40%">
                <div>
                    <h4>
                        <?= $order_detail->product->name ?>
                    </h4>
                    <span> <?= $order_detail->product->category->name ?> </span>

                    <div>
                        <span>Rp <?= number_format($order_detail->current_price, 0, ',', '.') ?></span>&nbsp;
                        <?php if (!is_null($order_detail->current_discount)) { ?>
                            <span class="label label-warning">Diskon <?= $order_detail->current_discount * 100 ?>
                                %</span>
                        <?php } ?>
                    </div>
                </div>
            </td>
            <td class="" style="border: 1px solid black; width:10%"><a> X <?= $order_detail->quantity ?> </a>
            </td>
            <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">
                <span> Rp <?= number_format(($order_detail->current_price - ($order_detail->current_price * $order_detail->current_discount)) * $order_detail->quantity, 0, ',', '.') ?> </span>
            </td>
        </tr>
    <?php } ?>
    <tr class="cartTotalTr blank">
        <td class="" style="width:20%">
            <div></div>
        </td>
        <td style="width:40%"></td>
        <td class="" style="width:20%"></td>
        <td class="" style="width:15%"><span>  </span></td>

    </tr>

    <tr class="cartTotalTr">
        <td colspan="3" style="border: 1px solid black; width:40%; text-align: right; font-weight: bold; font-size: 12pt">Jumlah</td>
        <td class="" style="border: 1px solid black; text-align: right; width:15%">
            <span> Rp <?= number_format($order->total_products_price_without_tax, 0, ',', '.') ?> </span>
        </td>

    </tr>
    <?php if($order->membership_discount) : ?>
    <tr class="cartTotalTr">
        <td colspan="3" style="border: 1px solid black; width:40%; text-align: right; font-weight: bold; font-size: 12pt">Diskon Member</td>
        <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">
            <span> - Rp <?=number_format($order->membership_discount, 0, ',', '.')?> </span>
        </td>
    </tr>
    <?php endif ?>
    <?php if($order->reseller_discount) : ?>
    <tr class="cartTotalTr">
        <td colspan="3" style="border: 1px solid black; width:40%; text-align: right; font-weight: bold; font-size: 12pt">Diskon Reseller</td>
        <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">
            <span> - Rp <?=number_format($order->reseller_discount, 0, ',', '.')?> </span>
        </td>
    </tr>
    <?php endif ?>
<!--    <tr class="cartTotalTr">-->
<!--        <td colspan="3" style="border: 1px solid black; width:40%; text-align: right; font-weight: bold; font-size: 12pt">PPN (10%)</td>-->
<!--        <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">-->
<!--            <span> Rp --><?//=number_format($order->total_tax, 0, ',', '.')?><!-- </span></td>-->
<!--    </tr>-->
    <tr class="cartTotalTr">
        <td colspan="3" style="border: 1px solid black; width:40%; text-align: right; font-weight: bold; font-size: 12pt">Ongkos Kirim</td>
        <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">
            <span> Rp <?= number_format($order->ship_price, 0, ',', '.') ?> </span>
        </td>

    </tr>
    <tr class="cartTotalTr">
        <td colspan="3" class="" style="border: 1px solid black; width:20%; text-align: right; font-weight: bold; font-size: 15pt">Total &nbsp;</td>
        <td class="" style="border: 1px solid black; width:15%; text-align: right; font-weight: bold;">
            <span class="price"> Rp <?= number_format($order->total_all, 0, ',', '.') ?> </span>
        </td>
    </tr>
    </tbody>
</table>
