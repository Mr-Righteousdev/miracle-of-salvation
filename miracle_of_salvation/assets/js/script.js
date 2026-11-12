
document.addEventListener("DOMContentLoaded", function () {

    const menuToggle = document.getElementById("menuToggle");
    const mainNavigation = document.getElementById("mainNavigation");
    const dropdownItems = document.querySelectorAll(".has-dropdown");

    // Open and close the mobile navigation
    if (menuToggle && mainNavigation) {

        menuToggle.addEventListener("click", function () {

            const isOpen = mainNavigation.classList.toggle("active");

            menuToggle.setAttribute("aria-expanded", isOpen);
            menuToggle.setAttribute(
                "aria-label",
                isOpen ? "Close navigation menu" : "Open navigation menu"
            );

        });

    }

    // Handle dropdown menus on mobile devices
    dropdownItems.forEach(function (item) {

        const link = item.querySelector(":scope > a");

        if (!link) return;

        link.addEventListener("click", function (event) {

            if (window.innerWidth <= 950) {

                const isOpen = item.classList.contains("open");

                if (!isOpen) {
                    event.preventDefault();

                    // Close other open dropdowns
                    dropdownItems.forEach(function (otherItem) {
                        if (otherItem !== item) {
                            otherItem.classList.remove("open");
                        }
                    });

                    item.classList.add("open");
                }

            }

        });

    });

    // Close menu when clicking outside
    document.addEventListener("click", function (event) {

        if (
            mainNavigation &&
            menuToggle &&
            !mainNavigation.contains(event.target) &&
            !menuToggle.contains(event.target)
        ) {
            mainNavigation.classList.remove("active");
            menuToggle.setAttribute("aria-expanded", "false");

            dropdownItems.forEach(function (item) {
                item.classList.remove("open");
            });
        }

    });

    // Close menu when pressing Escape
    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape" && mainNavigation && menuToggle) {

            mainNavigation.classList.remove("active");
            menuToggle.setAttribute("aria-expanded", "false");

            dropdownItems.forEach(function (item) {
                item.classList.remove("open");
            });

        }

    });

});
