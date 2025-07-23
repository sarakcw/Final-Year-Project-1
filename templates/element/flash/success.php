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
<div class="message success success-highlight" onclick="this.classList.add('hidden')"><?= $message ?></div>

<style>
    .success-highlight {
        position: relative;
        background: transparent; /* light green */
        color: #155724; /* dark green text */
        padding: 8px;
        border-radius: 7px;
        box-shadow: 0 0 15px 5px rgba(132, 159, 108, 0.5); /* glow effect */
        z-index: 1;
        transition: box-shadow 0.3s ease;
        width: auto;
        font-family: 'Comfortaa', sans-serif;
    }

    .success-highlight:hover {
        box-shadow: 0 0 20px 10px rgba(132, 159, 108, 0.7);
    }
    .hidden {
        display: none;
    }
</style>
