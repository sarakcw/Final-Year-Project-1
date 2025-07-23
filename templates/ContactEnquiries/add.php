<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactEnquiry $contactEnquiry
 * @var \App\Model\Entity\ContactEnquiry $recaptcha_user
 */

?>

<!--Google widget script-->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container mt-6 mb-5">

<!--    render the feedback message when successful or unsuccessful submission of form-->
    <div class="alert alert-dismissible fade show" role="alert">
        <?= $this->Flash->render('contactFeedback');?>
    </div>
    <div class="container contact-banner">
        <h4 class="text-center">CONTACT US</h4>
        <p class="text-center">Complete the form below to contact the team at Divine Vines</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-contact mt-5 mb-2">
                <div class="contact-card-header text-black text-center pt-2">
                    <h4><?= __(' _______ ') ?></h4>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($contactEnquiry) ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('first_name', ['label' => 'First Name *', 'class' => 'form-control', 'required'=>true,
                                'pattern' =>  '[A-Za-z\-]+',
                                'title' => 'Only alphabetic characters and hyphens are allowed']); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('last_name', ['label' => 'Last Name', 'class' => 'form-control',
                                'pattern' =>  '[A-Za-z\-]+',
                                'title' => 'Only alphabetic characters and hyphens are allowed']); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('email', ['label' => 'Email *', 'class' => 'form-control', 'type'=> 'email','required' =>true]); ?>
                        <?= $this->Form->error('email') ?> <!-- display error from backend -->
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('phone_number', [
                            'label' => 'Phone Number *', 'class' => 'form-control',
                            'type' => 'number'
                        ]); ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('message', ['label' => 'Message *', 'class' => 'form-control', 'placeholder'=> 'Your Message', 'required'=>true]);?>
                        <?= $this->Form->error('message') ?> <!-- display error from backend -->

                    </div>

                    <!-- Google reCAPTCHA widget -->
                    <div class="container-recaptcha mb-3">
                        <?= $this->Recaptcha -> display() ?>
                    </div>

                    <div class="text-center">
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-contact w-100']) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>


