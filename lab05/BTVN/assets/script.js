// JS cho AJAX add-to-cart và animation "fly to cart"
// Ghi chú: tách ra file riêng để mã gọn và có thể tái sử dụng
document.addEventListener('DOMContentLoaded', function () {
    // Đơn giản hóa: AJAX add-to-cart chỉ cập nhật số lượng và flash,
    // không có animation bay ảnh.
    function pulseBadge(badgeEl) {
        if (!badgeEl) return;
        badgeEl.style.transform = 'scale(1.12)';
        badgeEl.style.transition = 'transform 180ms ease';
        setTimeout(function () { badgeEl.style.transform = 'scale(1)'; }, 180);
    }

    document.querySelectorAll('form.ajax-add').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function (resp) { return resp.json(); })
            .then(function (json) {
                if (json && json.success) {
                    // cập nhật badge (header) và button view-cart nếu có
                    var cntEl = document.getElementById('cart-count');
                    if (cntEl) { cntEl.textContent = json.cartCount; pulseBadge(cntEl); }
                    var viewBtn = document.getElementById('view-cart-btn');
                    if (viewBtn) { viewBtn.textContent = 'Xem giỏ hàng (' + json.cartCount + ')'; }
                    // flash message: chèn vào container #page-flash (nếu tồn tại) để tránh nhảy layout
                    var flash = document.createElement('div');
                    flash.className = 'flash success';
                    flash.textContent = json.message || 'Đã thêm vào giỏ.';
                    var pageFlash = document.getElementById('page-flash');
                    if (pageFlash) {
                        pageFlash.innerHTML = '';
                        pageFlash.appendChild(flash);
                        // tự ẩn sau 2s
                        setTimeout(function () { pageFlash.innerHTML = ''; }, 2000);
                    } else {
                        document.body.insertBefore(flash, document.body.firstChild);
                        setTimeout(function () { flash.remove(); }, 2000);
                    }
                } else {
                    alert('Thêm vào giỏ thất bại');
                }
            }).catch(function (err) {
                console.error(err);
                alert('Lỗi khi thêm giỏ');
            });
        });
    });
});


