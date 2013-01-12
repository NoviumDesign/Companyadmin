<fieldset>
    <label>General details</label>
    <section>
        <label for="delivery">Private or company?</label>
            <div>

                <?= $this->element('type', 'company'); ?>

                <label for="type">Company</label>

                <?= $this->element('type', 'private'); ?>

                <label for="type">Private</label>
            </div>
    </section>
    <section>
        <label for="customerName">Customer name</label>
        <div>

            <?= $this->element('customerName'); ?>

        </div>
    </section>
</fieldset>

<fieldset>
    <label>Contact details</label>
    <section>
        <label for="phone">Phone</label>
        <div>

            <?= $this->element('phone'); ?>

        </div>
    </section>
    <section>
        <label for="mail">Email</label>
        <div>

            <?= $this->element('mail'); ?>

        </div>
    </section>
</fieldset>
 
<fieldset>
    <label>Invoice adress</label>
    <section>
        <label for="customerAdress">Invoice adress</label>
        <div>

            <?= $this->element('adress'); ?>

        </div>
    </section>
    <section>
        <label for="box">Box</label>
        <div>

            <?= $this->element('box'); ?>

        </div>
    </section>
    <section>
        <label for="zipCode">Zip code</label>
        <div>

            <?= $this->element('zipCode'); ?>

        </div>
    </section>
    <section>
        <label for="city">City</label>
        <div>

            <?= $this->element('city'); ?>

        </div>
    </section>
    <section>
        <label for="country">Country</label>
        <div>

            <?= $this->element('country'); ?>

        </div>
    </section>
</fieldset>

<fieldset>
    <label>Notes</label>
    <section>
        <label for="notes">Notes</label>
        <div>

            <?= $this->element('notes'); ?>

        </div>
    </section>
</fieldset>
<fieldset>
    <label>Save changes</label>
    <section>
        <div>

            <?= $this->element('addCustomer'); ?>

    </section>
</fieldset>