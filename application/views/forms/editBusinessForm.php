<fieldset>
    <label>Business</label>
    <section>
        <label for="delivery">Name</label>
        <div>

            <?= $this->element('businessName'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Company</label>
    <section>
        <label for="delivery">Name</label>
        <div>

            <?= $this->element('companyName'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Box</label>
        <div>

            <?= $this->element('companyBox'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Adress</label>
        <div>

            <?= $this->element('companyAdress'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Zip code</label>
        <div>

            <?= $this->element('companyZipCode'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">City</label>
        <div>

            <?= $this->element('companyCity'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Country</label>
        <div>

            <?= $this->element('companyCountry'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Invoice details</label>
    <section>
        <label for="logo">
            Company logo
            <br>
            <span>Left untouched will not overwrite current logo.</span>
        </label>

        <div>

            <?= $this->element('logo'); ?>

            <br>
            <i>       Allowed file types are .jpeg or .jpg</i>

        </div>
    </section>
    <section>
        <label for="delivery">invoice number prefix</label>
        <div>

            <?= $this->element('prefix'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Invoice detail</label>
        <div>

            <?= $this->element('detail'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Bank</label>
        <div>

            <?= $this->element('companyBank'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Org.nr</label>
        <div>

            <?= $this->element('companyOrgnr'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">theme color</label>
        <div>

            <?= $this->element('companyColor'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Contact details</label>
    <section>
        <label for="delivery">Site</label>
        <div>

            <?= $this->element('companySite'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Mail</label>
        <div>

            <?= $this->element('companyMail'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Phone</label>
        <div>

            <?= $this->element('companyPhone'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">Reference</label>
        <div>

            <?= $this->element('companyReference'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Confirmation Mail</label>
    <section>
        <label for="delivery">content</label>
        <div>

            <?= $this->element('confirmationMail'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Invoice Mail</label>
    <section>
        <label for="delivery">title</label>
        <div>

            <?= $this->element('invoiceMailTitle'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">content</label>
        <div>

            <?= $this->element('invoiceMailContent'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <label>Custom order fields</label>
    <section>
        <label for="delivery">1</label>
        <div>

            <?= $this->element('c1'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">2</label>
        <div>

            <?= $this->element('c2'); ?>

        </div>
    </section>
    <section>
        <label for="delivery">3</label>
        <div>

            <?= $this->element('c3'); ?>

        </div>
    </section>
</fieldset>


<fieldset>
    <section>
        <div>

            <?= $this->element('editBusiness'); ?>

        </div>
    </section>
</fieldset>


