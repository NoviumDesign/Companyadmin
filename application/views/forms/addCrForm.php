<?= $this->element('customerId') ?>
<fieldset>
    <label>Details</label>
    <section>
        <label>Status</label>
            <div>

                <?= $this->element('status', 'active'); ?>

                <label>Active</label>

                <?= $this->element('status', 'completed'); ?>

                <label>Completed</label>
            </div>
    </section>
    <section>
        <label>Customer</label>
        <div>

            <?= $this->element('customer'); ?>

        </div>
    </section>
    <section>
        <label>Date</label>
        <div>

            <?= $this->element('date'); ?>

        </div>
    </section>
</fieldset>

<fieldset>
    <label>Task</label>
    <section>
        <label>Task</label>
        <div>

            <?= $this->element('task'); ?>

        </div>
    </section>
</fieldset>

<fieldset>
    <label></label>
    <section>
        <div>

            <?= $this->element('submit'); ?>

    </section>
</fieldset>