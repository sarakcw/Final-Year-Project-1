<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Register new user');
?>

<div class="container mt-6 mb-5" style="margin-top: 4rem;">
    <div class="container contact-banner" style="background-color: #540b0e; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
        <h4 class="text-center" style="font-size: 2.8rem; font-weight: bold; margin-bottom: 1rem; color: white; font-family: Lora, serif;">REGISTER</h4>
        <p class="text-center" style="color: #e2e3e5; font-size: 1.8rem; font-family: Lora, serif;">Create a new account to access Divine Vines</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-contact mt-5 mb-2" style="background-color: white; border: 1px solid #dee2e6; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <div class="contact-card-header text-black text-center pt-2">
                </div>
                <div class="card-body">
                    <?= $this->Form->create($user) ?>
                    <?= $this->Flash->render('registerFeedback') ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('first_name', [
                                'label' => ['text' => 'First Name *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'required' => true,
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('last_name', [
                                'label' => ['text' => 'Last Name', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => ['text' => 'Email *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                            'class' => 'form-control',
                            'required' => true,
                            'autocomplete' => 'email',
                            'placeholder' => 'Enter your email',
                            'style' => 'font-family: Comfortaa, sans-serif;'
                        ]); ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('phone', [
                            'type' => 'number',
                            'label' => ['text' => 'Phone Number *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                            'class' => 'form-control',
                            'pattern' => '[0-9]*',
                            'inputmode' => 'numeric',
                            'style' => 'font-family: Comfortaa, sans-serif;'
                        ]); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('birth_month', [
                                'type' => 'select',
                                'label' => ['text' => 'Birth Month *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'required' => true,
                                'options' => [
                                    '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April',
                                    '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August',
                                    '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                                ],
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('birth_day', [
                                'type' => 'select',
                                'label' => ['text' => 'Birth Day *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'required' => true,
                                'options' => array_combine(range(1, 31), range(1, 31)),
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('address', [
                            'type' => 'text',
                            'label' => ['text' => 'Address *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                            'class' => 'form-control',
                            'required' => true,
                            'style' => 'font-family: Comfortaa, sans-serif;'
                        ]); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('password', [
                                'label' => ['text' => 'Password *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'required' => true,
                                'placeholder' => 'Password',
                                'autocomplete' => 'new-password',
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('password_confirm', [
                                'type' => 'password',
                                'label' => ['text' => 'Confirm Password *', 'style' => 'font-family: Comfortaa, sans-serif;'],
                                'class' => 'form-control',
                                'required' => true,
                                'placeholder' => 'Retype password',
                                'autocomplete' => 'new-password',
                                'style' => 'font-family: Comfortaa, sans-serif;'
                            ]); ?>
                        </div>
                    </div>

                    <div class="text-center">
                        <?= $this->Form->button('Register', [
                            'class' => 'btn btn-contact w-100',
                            'style' => 'background-color: #540b0e; border-color: #540b0e; color: white; transition: all 0.3s ease;',
                            'onmouseover' => 'this.style.backgroundColor="#9e2a2b"; this.style.borderColor="#9e2a2b"; this.style.color="#ffffff";',
                            'onmouseout' => 'this.style.backgroundColor="#540b0e"; this.style.borderColor="#540b0e"; this.style.color="#ffffff";'
                        ]) ?>
                    </div>
                    <div class="text-center mt-3">
                        <?= $this->Html->link('Back to login', ['controller' => 'Auth', 'action' => 'login'], [
                            'class' => 'btn btn-outline-contact',
                            'style' => 'color: #540b0e; border-color: #540b0e; transition: all 0.3s ease; margin-right: 1rem;',
                            'onmouseover' => 'this.style.backgroundColor="#540b0e"; this.style.borderColor="#540b0e"; this.style.color="#ffffff";',
                            'onmouseout' => 'this.style.backgroundColor="transparent"; this.style.borderColor="#540b0e"; this.style.color="#540b0e";'
                        ]) ?>
                        <?= $this->Html->link('Homepage', ['controller' => '/'], [
                            'class' => 'btn btn-outline-contact',
                            'style' => 'color: #540b0e; border-color: #540b0e; transition: all 0.3s ease;',
                            'onmouseover' => 'this.style.backgroundColor="#540b0e"; this.style.borderColor="#540b0e"; this.style.color="#ffffff";',
                            'onmouseout' => 'this.style.backgroundColor="transparent"; this.style.borderColor="#540b0e"; this.style.color="#540b0e";'
                        ]) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
