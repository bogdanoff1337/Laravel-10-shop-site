// public/js/admin.js

// Отримання всіх елементів вкладок та вмісту
const tabLinks = document.querySelectorAll(".tab-link");
const tabItems = document.querySelectorAll(".tab-item");

// Добробник подій кліків на кожну вкладку
tabLinks.forEach((link) => {
    link.addEventListener("click", () => {
        // Вимкнути всі активні вкладки та вміст
        tabLinks.forEach((link) => link.classList.remove("active"));
        tabItems.forEach((item) => item.classList.remove("active"));

        //ідентифікатор вкладки з атрибуту data
        const tabId = link.getAttribute("data-tab");

        // Знайти вкладку та вміст за ідентифікатором і додати клас активності
        const tab = document.getElementById(tabId);
        tab.classList.add("active");
        link.classList.add("active");
    });
});
