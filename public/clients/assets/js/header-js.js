document.addEventListener("DOMContentLoaded", function () {
    const userIcon = document.getElementById("userIcon");
    const dropdownMenu = document.getElementById("dropdownMenu");
    const userDropdown = document.getElementById("userDropdown");

    // Toggle menu khi click vào icon
    userIcon.addEventListener("click", function (e) {
        e.stopPropagation(); // Ngăn sự kiện lan ra window
        dropdownMenu.classList.toggle("show");
    });

    // Ngăn không đóng menu khi click bên trong dropdown (bao gồm cả thẻ <a>)
    userDropdown.addEventListener("click", function (e) {
        e.stopPropagation(); // Cho phép click thẻ <a> mà không bị đóng ngay
    });

    // Click ngoài dropdown sẽ đóng
    window.addEventListener("click", function () {
        dropdownMenu.classList.remove("show");
    });
});