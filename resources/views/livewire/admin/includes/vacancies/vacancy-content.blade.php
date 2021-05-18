<div id="vacancy-content" class="tab-pane">
    <div class="row">
        <div class="col-lg-6">

            <div class="form-group">
            <label for="vac_lp">Lead Paragraph</label>
            <textarea placeholder="Lead Paragraph" class="form-control" cols="40" rows="5" wire:model.lazy="vac_lp" name="vac_lp" id="vac_lp"></textarea>
            </div>

            <div wire:ignore>
            <div class="form-group">
            <label for="vac_desc">Vacancy description text</label>
            <textarea placeholder="Vacancy description text" class="form-control tiny_body" maxlength="999" wire:model.lazy="vac_desc" name="vac_desc" cols="50" rows="10" id="vac_desc"></textarea>
            </div>
            </div>

            <div class="form-group">
                <label for="vac_vid">Video URL</label>
                <input placeholder="Video URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="vac_vid" name="vac_vid" type="url" id="vac_vid">
            </div>

            <div class="form-group mb-4">
                <label for="vac_map">Map URL</label>
                <input placeholder="Map URL i.e. https://www.link.com" class="form-control" maxlength="255" wire:model="vac_map" name="vac_map" type="url" id="vac_map">
            </div>

            <label>Vacancy Image</label>
            <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Select image</label>
            </div>
        </div>
    </div>
    </div>
