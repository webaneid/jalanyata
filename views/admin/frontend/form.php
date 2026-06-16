<?php $frontendTemplateId = (int) ($selectedTemplate['id'] ?? 0); ?>
<?php if ($selectedTemplate === null): ?>
    <p class="ane-note">Belum ada template front-end yang tersedia.</p>
<?php else: ?>
    <h2 class="ane-page-head__title" style="font-size:1.25rem;">Editor Template: <?= htmlspecialchars((string) $selectedTemplate['template_name'], ENT_QUOTES, 'UTF-8') ?></h2>
    <form action="<?= htmlspecialchars($frontendTemplateAction, ENT_QUOTES, 'UTF-8') ?>" method="POST" class="ane-section-stack" style="margin-top:16px;">
        <input type="hidden" name="id" value="<?= (int) $frontendTemplateId ?>">
        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="template_name" class="ane-label">Nama Template</label>
                <input type="text" id="template_name" name="template_name" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplate['template_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="template_key" class="ane-label">Template Key</label>
                <input type="text" id="template_key" value="<?= htmlspecialchars((string) $selectedTemplate['template_key'], ENT_QUOTES, 'UTF-8') ?>" class="ane-input" readonly>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="page_title" class="ane-label">Page Title</label>
                <input type="text" id="page_title" name="page_title" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['page_title'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="page_description" class="ane-label">Page Description</label>
                <textarea id="page_description" name="page_description" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['page_description'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="home_eyebrow" class="ane-label">Home Eyebrow</label>
                <input type="text" id="home_eyebrow" name="home_eyebrow" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_eyebrow'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="home_title" class="ane-label">Home Title</label>
                <input type="text" id="home_title" name="home_title" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_title'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="home_lead" class="ane-label">Home Lead</label>
                <textarea id="home_lead" name="home_lead" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['home_lead'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="ane-field-group">
                <div class="ane-field">
                    <label for="home_search_eyebrow" class="ane-label">Search Eyebrow</label>
                    <input type="text" id="home_search_eyebrow" name="home_search_eyebrow" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_search_eyebrow'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="ane-field">
                    <label for="home_search_meta" class="ane-label">Search Meta</label>
                    <textarea id="home_search_meta" name="home_search_meta" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['home_search_meta'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
            </div>
        </div>

        <div class="ane-grid ane-grid--3">
            <div class="ane-field">
                <label for="home_placeholder" class="ane-label">Placeholder Input</label>
                <input type="text" id="home_placeholder" name="home_placeholder" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_placeholder'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="home_button_label" class="ane-label">Label Tombol</label>
                <input type="text" id="home_button_label" name="home_button_label" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_button_label'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="home_specimen_serial" class="ane-label">Label Serial</label>
                <input type="text" id="home_specimen_serial" name="home_specimen_serial" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_specimen_serial'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="verified_eyebrow" class="ane-label">Verified Eyebrow</label>
                <input type="text" id="verified_eyebrow" name="verified_eyebrow" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_eyebrow'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="verified_title" class="ane-label">Verified Title</label>
                <input type="text" id="verified_title" name="verified_title" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_title'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="verified_lead" class="ane-label">Verified Lead</label>
                <textarea id="verified_lead" name="verified_lead" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['verified_lead'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="ane-field">
                <label for="verified_meta" class="ane-label">Verified Meta</label>
                <textarea id="verified_meta" name="verified_meta" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['verified_meta'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="verified_label_code" class="ane-label">Verified Label Code</label>
                <input type="text" id="verified_label_code" name="verified_label_code" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_label_code'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="verified_label_category" class="ane-label">Verified Label Category</label>
                <input type="text" id="verified_label_category" name="verified_label_category" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_label_category'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="verified_label_weight" class="ane-label">Verified Label Weight</label>
                <input type="text" id="verified_label_weight" name="verified_label_weight" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_label_weight'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="verified_label_date" class="ane-label">Verified Label Date</label>
                <input type="text" id="verified_label_date" name="verified_label_date" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_label_date'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="verified_back_button_label" class="ane-label">Verified Button Label</label>
                <input type="text" id="verified_back_button_label" name="verified_back_button_label" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['verified_back_button_label'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="invalid_eyebrow" class="ane-label">Invalid Eyebrow</label>
                <input type="text" id="invalid_eyebrow" name="invalid_eyebrow" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_eyebrow'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="invalid_title" class="ane-label">Invalid Title</label>
                <input type="text" id="invalid_title" name="invalid_title" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_title'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="invalid_lead" class="ane-label">Invalid Lead</label>
                <textarea id="invalid_lead" name="invalid_lead" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['invalid_lead'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="ane-field-group">
                <div class="ane-field">
                    <label for="invalid_meta" class="ane-label">Invalid Meta</label>
                    <textarea id="invalid_meta" name="invalid_meta" class="ane-textarea" rows="3" required><?= htmlspecialchars((string) $selectedTemplateConfig['invalid_meta'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <div class="ane-field">
                    <label for="invalid_serial" class="ane-label">Invalid Serial</label>
                    <input type="text" id="invalid_serial" name="invalid_serial" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_serial'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="invalid_label_status" class="ane-label">Invalid Label Status</label>
                <input type="text" id="invalid_label_status" name="invalid_label_status" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_label_status'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="invalid_label_product" class="ane-label">Invalid Label Product</label>
                <input type="text" id="invalid_label_product" name="invalid_label_product" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_label_product'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="invalid_label_action" class="ane-label">Invalid Label Action</label>
                <input type="text" id="invalid_label_action" name="invalid_label_action" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_label_action'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="invalid_back_button_label" class="ane-label">Invalid Button Label</label>
                <input type="text" id="invalid_back_button_label" name="invalid_back_button_label" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_back_button_label'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--3">
            <div class="ane-field">
                <label for="invalid_detail_status_value" class="ane-label">Invalid Status Value</label>
                <input type="text" id="invalid_detail_status_value" name="invalid_detail_status_value" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_detail_status_value'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="invalid_detail_product_value" class="ane-label">Invalid Product Value</label>
                <input type="text" id="invalid_detail_product_value" name="invalid_detail_product_value" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_detail_product_value'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="invalid_detail_action_value" class="ane-label">Invalid Action Value</label>
                <input type="text" id="invalid_detail_action_value" name="invalid_detail_action_value" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['invalid_detail_action_value'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="home_specimen_subtype" class="ane-label">Specimen Subtype</label>
                <input type="text" id="home_specimen_subtype" name="home_specimen_subtype" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_specimen_subtype'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="home_specimen_type" class="ane-label">Specimen Type</label>
                <input type="text" id="home_specimen_type" name="home_specimen_type" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_specimen_type'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-grid ane-grid--2">
            <div class="ane-field">
                <label for="home_specimen_grade" class="ane-label">Specimen Grade</label>
                <input type="text" id="home_specimen_grade" name="home_specimen_grade" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_specimen_grade'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="ane-field">
                <label for="home_specimen_weight" class="ane-label">Specimen Weight</label>
                <input type="text" id="home_specimen_weight" name="home_specimen_weight" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['home_specimen_weight'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
        </div>

        <div class="ane-field">
            <label for="footer_note" class="ane-label">Footer Note</label>
            <input type="text" id="footer_note" name="footer_note" class="ane-input" value="<?= htmlspecialchars((string) $selectedTemplateConfig['footer_note'], ENT_QUOTES, 'UTF-8') ?>" required>
        </div>

        <div class="ane-actions ane-actions--start">
            <label class="ane-note">
                <input type="checkbox" name="is_active" value="1" <?= (int) ($selectedTemplate['is_active'] ?? 0) === 1 ? 'checked' : '' ?>>
                Aktifkan template ini
            </label>
            <button type="submit" class="ane-button">Simpan Template</button>
        </div>
    </form>
<?php endif; ?>
