document.addEventListener("DOMContentLoaded", function() {
    const headers = document.querySelectorAll(".header");
    
    if(headers) {
        headers.forEach(header => {
            if(header.classList.contains("general")) {
                const navigationMobile = header.querySelector(".navigation-mobile");
                const navigationMobileButton = header.querySelector(".menu");

                navigationMobileButton.addEventListener("click", function() {
                    navigationMobile.classList.toggle("open");
                    navigationMobileButton.classList.toggle("open");
                });
            }
        })
    }
});