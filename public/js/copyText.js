document.addEventListener("DOMContentLoaded", function () {
    const clipboardButtons = document.querySelectorAll(".copyClipboard");

    clipboardButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const targetId = this.getAttribute("data-clipboard-target");
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const textToCopy =
                    targetElement.innerText || targetElement.textContent;

                navigator.clipboard
                    .writeText(textToCopy)
                    .then(() => {
                        console.log("Text copied to clipboard:", textToCopy);

                        // Change the button text to "Copied" after successful copy
                        button.textContent = "Copied";
                        button.disabled = true; // Optionally, disable the button after copying
                    })
                    .catch((err) => {
                        console.error("Unable to copy to clipboard.", err);
                        // Handle any errors if the copy operation fails
                    });
            }
        });
    });
});
