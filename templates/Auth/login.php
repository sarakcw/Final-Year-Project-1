<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$debug = Configure::read('debug');

$this->layout = 'login';
$this->assign('title', 'Login');
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container mt-6 mb-5" style="margin-top: 4rem;">
    <div class="container contact-banner" style="background-color: #540b0e; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
        <h4 class="text-center" style="font-size: 2.8rem; font-weight: bold; margin-bottom: 1rem; color: white; font-family: Lora, serif;">LOGIN</h4>
        <p class="text-center" style="color: #e2e3e5; font-size: 1.8rem; font-family: Lora, serif;">Welcome back to Divine Vines</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-contact mt-5 mb-2" style="background-color: white; border: 1px solid #dee2e6; border-radius: 0.5rem; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                <div class="card-body">
                    <?= $this->Form->create() ?>
                    <?= $this->Flash->render('authFeedback') ?>

                    <div class="mb-3">
                        <?= $this->Form->control('email', [
                            'type' => 'email',
                            'label' => 'Email *',
                            'class' => 'form-control',
                            'required' => true,
                            'autofocus' => true,
                            'value' => $debug ? "test@example.com" : "",
                            'placeholder' => 'Enter your email',
                            'style' => 'font-family: Comfortaa, sans-serif;'
                        ]); ?>
                    </div>

                    <div class="mb-3">
                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => 'Password *',
                            'class' => 'form-control',
                            'required' => true,
                            'value' => $debug ? 'password' : '',
                            'placeholder' => 'Enter your password',
                            'style' => 'font-family: Comfortaa, sans-serif;'
                        ]); ?>
                    </div>

                    <!-- Google reCAPTCHA widget -->
                    <div class="container-recaptcha mb-3">
                        <?= $this->Recaptcha->display() ?>
                    </div>

                    <div class="text-center">
                        <?= $this->Form->button('Login', [
                            'class' => 'btn btn-contact w-100',
                            'style' => 'background-color: #540b0e; border-color: #540b0e; color: white; transition: all 0.3s ease;',
                            'onmouseover' => 'this.style.backgroundColor="#9e2a2b"; this.style.borderColor="#9e2a2b"; this.style.color="#ffffff";',
                            'onmouseout' => 'this.style.backgroundColor="#540b0e"; this.style.borderColor="#540b0e"; this.style.color="#ffffff";'
                        ]) ?>
                    </div>
                    <div class="text-center mt-3">
                        <?= $this->Html->link('Forgot password?', ['controller' => 'Auth', 'action' => 'forgetPassword'], [
                            'class' => 'btn btn-outline-contact',
                            'style' => 'color: #540b0e; border-color: #540b0e; transition: all 0.3s ease; margin-right: 1rem;',
                            'onmouseover' => 'this.style.backgroundColor="#540b0e"; this.style.borderColor="#540b0e"; this.style.color="#ffffff";',
                            'onmouseout' => 'this.style.backgroundColor="transparent"; this.style.borderColor="#540b0e"; this.style.color="#540b0e";'
                        ]) ?>
                        <?= $this->Html->link('Register new user', ['controller' => 'Auth', 'action' => 'register'], [
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
