/* ============================================================
   KIJURA TOWN COUNCIL — Admin JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar toggle
    var toggleBtn = document.getElementById('sidebarToggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            var isDesktop = window.innerWidth >= 992;
            if (isDesktop) {
                document.body.classList.toggle('sidebar-collapsed');
            } else {
                document.body.classList.toggle('sidebar-open');
            }
        });
    }

    // ── Close sidebar on outside click (mobile)
    document.addEventListener('click', function (e) {
        if (window.innerWidth < 992) {
            var sidebar = document.getElementById('adminSidebar');
            var toggle  = document.getElementById('sidebarToggle');
            if (sidebar && !sidebar.contains(e.target) && toggle && !toggle.contains(e.target)) {
                document.body.classList.remove('sidebar-open');
            }
        }
    });

    // ── Auto-dismiss alerts after 4 s
    document.querySelectorAll('.alert-dismissible').forEach(function (el) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });

    // ── Confirm delete buttons
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var msg = el.dataset.confirm || 'Are you sure you want to delete this item?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // ── Image preview on file input
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var previewId = input.dataset.preview;
            var preview   = document.getElementById(previewId);
            if (preview && input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) { preview.src = e.target.result; preview.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    // ── Character counter for textareas with data-maxlength
    document.querySelectorAll('textarea[data-maxlength], input[data-maxlength]').forEach(function (el) {
        var max      = parseInt(el.dataset.maxlength, 10);
        var counter  = document.createElement('small');
        counter.className = 'text-muted';
        el.parentNode.appendChild(counter);
        function update() {
            var remaining = max - el.value.length;
            counter.textContent = remaining + ' characters remaining';
            counter.className   = remaining < 20 ? 'text-danger small' : 'text-muted small';
        }
        el.addEventListener('input', update);
        update();
    });
});
