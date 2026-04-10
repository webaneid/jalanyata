<div class="ane-table-wrap">
    <table class="ane-table">
        <thead>
            <tr>
                <th scope="col"><input type="checkbox" id="select-all-checkbox"></th>
                <th scope="col">Kode ID</th>
                <th scope="col">QR Code</th>
                <th scope="col">Berat</th>
                <th scope="col">Tanggal Produksi</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <?php
                $rowAttributes = [
                    'data-id="' . (int) $product['id'] . '"',
                    'data-code="' . htmlspecialchars((string) $product['product_id_code'], ENT_QUOTES, 'UTF-8') . '"',
                    'data-weight="' . htmlspecialchars((string) $product['product_weight'], ENT_QUOTES, 'UTF-8') . '"',
                ];

                if (array_key_exists('product_date', $product)) {
                    $rowAttributes[] = 'data-date="' . htmlspecialchars((string) $product['product_date'], ENT_QUOTES, 'UTF-8') . '"';
                }
                ?>
                <tr <?= implode(' ', $rowAttributes) ?>>
                    <td><input type="checkbox" name="selected_products[]" value="<?= (int) $product['id'] ?>"></td>
                    <td><?= htmlspecialchars((string) $product['product_id_code'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <div id="qrcode-<?= (int) $product['id'] ?>" class="qr-block"></div>
                        <button onclick="downloadQRCode(<?= (int) $product['id'] ?>)" class="ane-link ane-link-button" style="margin-top:8px;">Download</button>
                    </td>
                    <td><?= htmlspecialchars((string) $product['product_weight'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string) ($product['product_date'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?php call_user_func($rowActionRenderer, $product); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
