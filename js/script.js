
(() => {
  "use strict";

  // Helpers
  const $  = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  function showTempAlert(target, message, type = "info", timeout = 2500) {
    // type: primary, secondary, success, danger, warning, info, light, dark
    const alert = document.createElement("div");
    alert.className = `alert alert-${type} mt-3`;
    alert.textContent = message;
    target.appendChild(alert);
    setTimeout(() => alert.remove(), timeout);
  }

  // Activate current nav link by pathname
  function activateNavLink() {
    const path = location.pathname.split("/").pop() || "index.php";
    $$(".navbar .nav-link").forEach(link => {
      try {
        const href = (link.getAttribute("href") || "").split("/").pop();
        if (href && href === path) {
          link.classList.add("active");
        } else {
          link.classList.remove("active");
        }
      } catch (_) {}
    });
  }

  // Admin dashboard: try fetch stats (fails gracefully if API missing)
  async function tryLoadAdminSummary() {
    const totalRevenue    = $("#totalRevenue");
    const totalCourses    = $("#totalCourses");
    const totalUsers      = $("#totalUsers");
    const totalVisitors = $("#totalVisitors");
    const latestCoursesList = $("#latestCoursesList");
    const latestUsersList   = $("#latestUsersList");

    // لو العناصر دي مش موجودة في الصفحة الحالية خلاص نخرج
    if (!totalRevenue && !totalCourses && !totalUsers && !totalVisitors && !latestCoursesList && !latestUsersList) {
      return;
    }

    try {
      // API المقترح لاحقًا
      const res = await fetch("/api/admin/summary.php", { headers: { "Accept": "application/json" } });
      if (!res.ok) return; // ما نبوّظش الدنيا
      const data = await res.json();

      if (totalRevenue && data.totalRevenue != null)  totalRevenue.textContent    = `${data.totalRevenue}$`;
      if (totalCourses && data.totalCourses != null)  totalCourses.textContent    = data.totalCourses;
      if (totalUsers && data.totalUsers != null)      totalUsers.textContent      = data.totalUsers;
      if (totalVisitors && data.totalVisitors != null) totalVisitors.textContent = data.totalVisitors;

      if (Array.isArray(data.latestCourses) && latestCoursesList) {
        latestCoursesList.innerHTML = "";
        data.latestCourses.forEach(c => {
          const li = document.createElement("li");
          li.className = "list-group-item d-flex justify-content-between align-items-center";
          li.innerHTML = `<span>${c.title}</span><span class="badge bg-primary rounded-pill">${(c.price ?? 0)}$</span>`;
          latestCoursesList.appendChild(li);
        });
      }

      if (Array.isArray(data.latestUsers) && latestUsersList) {
        latestUsersList.innerHTML = "";
        data.latestUsers.forEach(u => {
          const li = document.createElement("li");
          li.className = "list-group-item d-flex justify-content-between align-items-center";
          li.innerHTML = `<span>${u.name}</span><span class="text-muted small">${u.role || ""}</span>`;
          latestUsersList.appendChild(li);
        });
      }
    } catch (_) {
      // تجاهل أي أخطاء لحد ما الـ API يتجهز
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    activateNavLink();
    // wireFormValidation(); // ✅ تم تعليق هذا السطر
  });
})();

document.addEventListener('DOMContentLoaded', () => {
    // Other functions here...

    // Sidebar toggle for smaller screens
    const sidebar = document.querySelector('.sidebar-wrapper');
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    const content = document.querySelector('.content-wrapper');

    if (toggleBtn && sidebar && content) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Hide sidebar on content click for small screens
    if (content) {
        content.addEventListener('click', () => {
            if (window.innerWidth <= 991) {
                sidebar.classList.remove('show');
            }
        });
    }
});