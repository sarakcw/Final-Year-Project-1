<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error error-highlight" onclick="this.classList.add('hidden');"><?= $message ?></div>
<style>
    .error-highlight {
        position: relative;
        background: transparent; /* light green */
        color: #b12704; /* dark green text */
        padding: 8px;
        border-radius: 5px;
        box-shadow: 0 0 15px 5px rgba(177, 39, 4, 0.5); /* glow effect */
        z-index: 1;
        transition: box-shadow 0.3s ease;
        width: auto;
        font-family: 'Comfortaa', sans-serif;
    }

    .error-highlight:hover {
        box-shadow: 0 0 20px 10px rgba(177, 39, 4, 0.5);
    }
    .hidden {
        display: none;
    }
</style>
