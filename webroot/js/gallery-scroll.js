document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".gallery-container");
    const gallery = document.querySelector(".gallery");
    const leftArrow = document.querySelector(".arrow-nav.left");
    const rightArrow = document.querySelector(".arrow-nav.right");

    if (!container || !gallery || !leftArrow || !rightArrow) {
        console.error("Required gallery elements not found");
        return;
    }

    const updateArrows = () => {
        const maxScrollLeft = container.scrollWidth - container.clientWidth;
        const scrollLeft = container.scrollLeft;

        // Update arrow states
        leftArrow.style.opacity = scrollLeft <= 0 ? "0.3" : "1";
        leftArrow.style.pointerEvents = scrollLeft <= 0 ? "none" : "auto";
        rightArrow.style.opacity = scrollLeft >= maxScrollLeft - 1 ? "0.3" : "1"; // -1 for rounding errors
        rightArrow.style.pointerEvents = scrollLeft >= maxScrollLeft - 1 ? "none" : "auto";
    };

    const scrollAmount = () => {
        const card = gallery.querySelector(".product-card");
        if (!card) return 0;
        const cardStyle = getComputedStyle(card);
        const cardWidth = card.offsetWidth + parseInt(cardStyle.marginRight) + parseInt(cardStyle.marginLeft);
        return cardWidth; // Scroll by 1 card at a time for better control
    };

    leftArrow.addEventListener("click", () => {
        const amount = scrollAmount();
        container.scrollBy({ left: -amount, behavior: "smooth" });
        setTimeout(updateArrows, 300); // Update after scroll animation
    });

    rightArrow.addEventListener("click", () => {
        const amount = scrollAmount();
        container.scrollBy({ left: amount, behavior: "smooth" });
        setTimeout(updateArrows, 300); // Update after scroll animation
    });

    // Debounce scroll updates
    let scrollTimeout;
    container.addEventListener("scroll", () => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(updateArrows, 100);
    });

    window.addEventListener("resize", updateArrows);
    updateArrows(); // Initial call
});
