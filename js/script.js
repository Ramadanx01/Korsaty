/* قائمة الكورسات والمستخدمين، يتم جلبها من localStorage أو استخدام القيم الافتراضية */
let courses = JSON.parse(localStorage.getItem("courses")) || [
    { title: "كورس JavaScript", instructor: "أحمد علي", price: "50", image: "https://imgs.search.brave.com/KdDorxMeLzwINdYF0bMRpoZ5K_TCVFXpYbiqgzTKaUY/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTMw/NDM2ODg5NS92ZWN0/b3IvamF2YXNjcmlw/dC1qYXZhc2NyaXB0/LXByb2dyYW1taW5n/LWxhbmd1YWdlLXdp/dGgtc2NyaXB0LWNv/ZGUtb24tbGFwdG9w/LXNjcmVlbi5qcGc_/cz02MTJ4NjEyJnc9/MCZrPTIwJmM9RkN5/dDAyOVZEVS1Wdm95/SkRhUUljVkV2eFhM/djBPOHZHaURJV09T/U2Zhcz0" },
    { title: "كورس تصميم UI/UX", instructor: "سارة حسن", price: "70", image: "https://imgs.search.brave.com/TKd-BsiUBg3YY2RNHWomLOhVBjF0qTNTnLILQ-uQ-vE/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly93d3cu/bTNhYXJmLmNvbS9z/dG9yYWdlL2ltYWdl/cy82NzcxMTdjYTU4/ZTgwLmpwZw" },
    { title: "كورس تسويق رقمي", instructor: "محمد خالد", price: "60", image: "https://imgs.search.brave.com/mD8j-sC2WsPEKJEi-FDzwnY2j4xIlAW5jvKtP4EYNoE/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pLmli/Yi5jby9QWmJNSGNn/Yi8zNWI3NTktMWMw/NDRhZjAzZGE2NDFj/NDg4MjQ5YzE5Yjc5/YzAyZmEtbXYyLmpw/Zw" }
];

let users = JSON.parse(localStorage.getItem("users")) || []; // ابدأ بقائمة فارغة إذا لم تكن موجودة

// إضافة حساب الأدمن الافتراضي إذا لم يكن موجودًا بالفعل
const defaultAdminUser = { username: "admin", email: "admin@korsaty.com", password: "Admin123", phone: "+1234567890", isAdmin: true };
if (!users.some(user => user.email === defaultAdminUser.email)) {
    users.push(defaultAdminUser);
    saveUsers(); // حفظ المستخدمين بعد إضافة الأدمن
}

// تم تغيير currentUser ليتم جلبه من localStorage ليبقى المستخدم مسجلاً للدخول عبر الصفحات
let currentUser = JSON.parse(localStorage.getItem("currentUser")) || null;

/* حفظ الكورسات في localStorage */
function saveCourses() {
    localStorage.setItem("courses", JSON.stringify(courses));
}

/* حفظ المستخدمين في localStorage */
function saveUsers() {
    localStorage.setItem("users", JSON.stringify(users));
}

/* حفظ المستخدم الحالي في localStorage */
function saveCurrentUser() {
    localStorage.setItem("currentUser", JSON.stringify(currentUser));
}

/* عرض الكورسات في صفحات index و all-courses */
function renderCourses() {
    let courseList = document.getElementById("courseList");
    if (courseList) {
        courseList.innerHTML = ""; // تنظيف القائمة القديمة
        if (courses && courses.length > 0) {
            for (let course of courses) {
                courseList.innerHTML += `
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="${course.image}" class="card-img-top" alt="${course.title}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary">${course.title}</h5>
                                <p class="card-text">مدرب: ${course.instructor}</p>
                                <p class="card-text">السعر: ${course.price} $</p>
                                <a href="#" class="btn btn-primary mt-auto">عرض التفاصيل</a>
                            </div>
                        </div>
                    </div>
                `;
            }
        } else {
            courseList.innerHTML = "<p class='text-center text-muted'>لا توجد كورسات لعرضها حاليًا.</p>";
        }
    }
}

/* عرض الكورسات في جدول لوحة التحكم */
function renderCourseTable() {
    let courseListTable = document.getElementById("courseListTable");
    if (courseListTable) {
        courseListTable.innerHTML = ""; // تنظيف الجدول القديم
        if (courses && courses.length > 0) {
            for (let [index, course] of courses.entries()) {
                courseListTable.innerHTML += `
                    <tr>
                        <td>${course.title}</td>
                        <td>${course.instructor}</td>
                        <td>${course.price} $</td>
                        <td><img src="${course.image}" alt="${course.title}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                        <td><button class="btn btn-danger btn-sm" onclick="deleteCourse(${index})">مسح</button></td>
                    </tr>
                `;
            }
        } else {
            courseListTable.innerHTML = "<tr><td colspan='5' class='text-center text-muted'>لا توجد كورسات في القائمة.</td></tr>";
        }
    }
}

/* حذف كورس مع تحديث القناة */
function deleteCourse(index) {
    if (confirm("هل أنت متأكد من حذف هذا الكورس؟")) {
        courses.splice(index, 1); // حذف الكورس من القائمة
        saveCourses(); // حفظ التغييرات
        renderCourseTable(); // تحديث الجدول
        let channel = new BroadcastChannel('courseUpdates');
        channel.postMessage({ action: 'update' }); // إرسال إشارة تحديث
    }
}

/* عرض المستخدمين في صفحة users.html */
function renderUsers() {
    let userList = document.getElementById("userList");
    if (userList) {
        userList.innerHTML = ""; // تنظيف القائمة القديمة
        if (users && users.length > 0) {
            for (let [index, user] of users.entries()) {
                // لا تعرض حساب الأدمن في قائمة المستخدمين العاديين
                if (!user.isAdmin) {
                    userList.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            (${index + 1}) ${user.username} - ${user.email} - ${user.password} - ${user.phone}
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${index})">مسح</button>
                        </li>`;
                }
            }
            // إذا لم يكن هناك مستخدمون غير الأدمن
            if (userList.innerHTML === "") {
                userList.innerHTML = "<li class='list-group-item text-center text-muted'>لا توجد حسابات مسجلة حاليًا (باستثناء حساب الأدمن).</li>";
            }
        } else {
            userList.innerHTML = "<li class='list-group-item text-center text-muted'>لا توجد حسابات مسجلة حاليًا.</li>";
        }
    }
}

/* حذف مستخدم مع تحديث القناة */
function deleteUser(index) {
    if (confirm("هل أنت متأكد من حذف هذا الحساب؟")) {
        users.splice(index, 1); // حذف المستخدم
        saveUsers(); // حفظ التغييرات
        renderUsers(); // تحديث القائمة
        let channel = new BroadcastChannel('userUpdates');
        channel.postMessage({ action: 'update' }); // إرسال إشارة تحديث
    }
}

/* إعداد نموذج إضافة الكورس */
function setupAdminForm() {
    let courseForm = document.getElementById("courseForm");
    if (courseForm) {
        courseForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع تحديث الصفحة
            if (!courseForm.checkValidity()) {
                e.stopPropagation();
                courseForm.classList.add("was-validated");
                return;
            }
            let title = document.getElementById("title").value;
            let instructor = document.getElementById("instructor").value;
            let price = document.getElementById("price").value;
            let image = document.getElementById("image").value;
            // التحقق من السعر
            if (isNaN(price) || price.trim() === "") {
                alert("السعر يجب أن يكون رقمًا فقط!");
                return;
            }
            // التحقق من رابط الصورة
            const urlPattern = /^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/[a-zA-Z0-9]+\.[^\s]{2,}|[a-zA-Z0-9]+\.[^\s]{2,})$/i;
            if (!urlPattern.test(image)) {
                alert("يرجى إدخال رابط صورة صحيح (يجب أن يبدأ بـ http:// أو https://).");
                return;
            }
            let newCourse = { title, instructor, price: parseFloat(price), image };
            courses.push(newCourse); // إضافة الكورس
            saveCourses(); // حفظ التغييرات
            alert("تم إضافة الكورس بنجاح!");
            courseForm.reset(); // إعادة ضبط النموذج
            courseForm.classList.remove("was-validated");
            renderCourseTable(); // تحديث الجدول
            let channel = new BroadcastChannel('courseUpdates');
            channel.postMessage({ action: 'update' }); // إرسال إشارة تحديث
        });
    }
}

/* إعداد نموذج تسجيل الحساب */
function setupRegisterForm() {
    let registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع تحديث الصفحة
            let username = document.getElementById("username").value;
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let phone = document.getElementById("phone").value;
            // التحقق من الحقول
            if (username.trim() === "" || email.trim() === "" || password.trim() === "" || phone.trim() === "") {
                alert("يرجى ملء جميع الحقول.");
                return;
            }
            // التحقق من الإيميل
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("يرجى إدخال بريد إلكتروني صحيح.");
                return;
            }
            // التحقق من وجود الإيميل مسبقًا
            if (users.some(user => user.email === email)) {
                alert("البريد الإلكتروني مسجل بالفعل!");
                return;
            }
            // التحقق من كلمة السر
            if (password.includes(" ")) {
                alert("كلمة السر يجب ألا تحتوي على فراغات!");
                return;
            }
            let newUser = { username, email, password, phone, timestamp: new Date().toISOString(), isAdmin: false };
            users.push(newUser); // إضافة المستخدم
            saveUsers(); // حفظ التغييرات
            alert("تم تسجيل الحساب بنجاح!");
            currentUser = newUser; // تعيين المستخدم الحالي
            saveCurrentUser(); // حفظ المستخدم الحالي
            showWelcomeMessage(); // عرض رسالة الترحيب
            updateAuthLink(); // تحديث رابط تسجيل الدخول/الخروج
            registerForm.reset(); // إعادة ضبط النموذج
            let modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            modal.hide(); // إغلاق النافذة
            let channel = new BroadcastChannel('userUpdates');
            channel.postMessage({ action: 'update' }); // إرسال إشارة تحديث
        });
    }
}

/* إعداد نموذج تسجيل الدخول */
function setupLoginForm() {
    let loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع تحديث الصفحة
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            // التحقق من الحقول
            if (!loginForm.checkValidity()) {
                e.stopPropagation();
                loginForm.classList.add("was-validated");
                return;
            }
            // التحقق من وجود المستخدم
            let user = users.find(u => u.email === email && u.password === password);
            if (!user) {
                alert("البريد الإلكتروني أو كلمة السر غير صحيحة!");
                return;
            }
            currentUser = user; // تعيين المستخدم الحالي
            saveCurrentUser(); // حفظ المستخدم الحالي
            loginForm.reset(); // إعادة ضبط النموذج
            loginForm.classList.remove("was-validated");
            // إذا كان أدمن، يتم توجيهه إلى لوحة التحكم
            if (user.isAdmin) {
                window.location.href = "admin.html";
            } else {
                window.location.href = "index.html"; // توجيه المستخدم العادي للصفحة الرئيسية
            }
        });
    }
}

/* إعداد نموذج التواصل */
function setupContactForm() {
    let contactLogin = document.getElementById("contactLogin");
    let contactForm = document.getElementById("contactForm");
    let contactLoginPrompt = document.getElementById("contactLoginPrompt"); // رسالة المطالبة بتسجيل الدخول

    // إظهار نموذج تسجيل الدخول أولاً إذا لم يكن هناك مستخدم مسجل
    if (contactLogin && contactForm) {
        if (currentUser) {
            contactLogin.style.display = "none";
            contactForm.style.display = "block"; // إظهار نموذج التواصل مباشرة
            contactLoginPrompt.style.display = "none"; // إخفاء رسالة المطالبة
            document.getElementById("email").value = currentUser.email; // ملء الإيميل تلقائيًا
            document.getElementById("name").value = currentUser.username; // ملء الاسم تلقائيًا
        } else {
            contactLogin.style.display = "block"; // إظهار نموذج تسجيل الدخول
            contactForm.style.display = "none";
            contactLoginPrompt.style.display = "block"; // إظهار رسالة المطالبة
        }

        let verifyContact = document.getElementById("verifyContact");
        if (verifyContact) { // التأكد من وجود الزر قبل إضافة المستمع
            verifyContact.addEventListener('click', function(e) {
                e.preventDefault(); // منع تحديث الصفحة
                let email = document.getElementById("contactEmail").value;
                let password = document.getElementById("contactPassword").value;
                // التحقق من الحقول
                if (!email || !password) {
                    alert("يرجى ملء جميع الحقول.");
                    return;
                }
                // التحقق من وجود المستخدم
                let user = users.find(u => u.email === email && u.password === password);
                if (!user) {
                    alert("البريد الإلكتروني أو كلمة السر غير صحيحة!");
                    return;
                }
                currentUser = user; // تعيين المستخدم الحالي
                saveCurrentUser(); // حفظ المستخدم الحالي
                contactLogin.style.display = "none";
                contactForm.style.display = "block"; // إظهار نموذج التواصل
                contactLoginPrompt.style.display = "none"; // إخفاء رسالة المطالبة
                document.getElementById("email").value = user.email; // ملء الإيميل تلقائيًا
                document.getElementById("name").value = user.username; // ملء الاسم تلقائيًا
                updateAuthLink(); // تحديث رابط تسجيل الدخول/الخروج
            });
        }

        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع تحديث الصفحة
            if (!contactForm.checkValidity()) {
                e.stopPropagation();
                contactForm.classList.add("was-validated");
                return;
            }
            alert("تم إرسال استفسارك بنجاح! سنتواصل معك قريبًا.");
            contactForm.reset(); // إعادة ضبط النموذج
            contactForm.classList.remove("was-validated");
            // بعد الإرسال، يمكن إخفاء النموذج أو إعادة توجيه المستخدم
            // contactForm.style.display = "none";
            // contactLogin.style.display = "block"; // إعادة إظهار نموذج تسجيل الدخول إذا أردت
        });
    }
}

/* عرض رسالة الترحيب */
function showWelcomeMessage() {
    let welcomeMessage = document.getElementById("welcomeMessage");
    if (welcomeMessage && currentUser) {
        welcomeMessage.style.display = "block";
        welcomeMessage.textContent = `أهلاً أستاذ ${currentUser.username}، مرحبًا بك في كورساتي!`;
    } else if (welcomeMessage) {
        welcomeMessage.style.display = "none"; // إخفاء الرسالة إذا لم يكن هناك مستخدم
    }
}

/* تحديث رابط تسجيل الدخول/الخروج في شريط التنقل */
function updateAuthLink() {
    const authLink = document.getElementById('authLink');
    const authNavItem = document.getElementById('authNavItem');
    if (authLink && authNavItem) {
        if (currentUser) {
            authLink.textContent = 'تسجيل الخروج';
            authLink.href = '#'; // سيتم التعامل مع تسجيل الخروج بواسطة JavaScript
            authLink.addEventListener('click', handleLogout);

            // إخفاء روابط الأدمن إذا لم يكن المستخدم أدمن
            const adminLink = document.querySelector('.navbar-nav .nav-item a[href="admin.html"]');
            const usersLink = document.querySelector('.navbar-nav .nav-item a[href="users.html"]');
            if (adminLink && usersLink) {
                if (!currentUser.isAdmin) {
                    adminLink.parentElement.style.display = 'none';
                    usersLink.parentElement.style.display = 'none';
                } else {
                    adminLink.parentElement.style.display = ''; // إظهار إذا كان أدمن
                    usersLink.parentElement.style.display = ''; // إظهار إذا كان أدمن
                }
            }
        } else {
            authLink.textContent = 'تسجيل الدخول';
            authLink.href = 'login.html';
            authLink.removeEventListener('click', handleLogout); // إزالة المستمع إذا لم يكن مسجلاً للدخول

            // إخفاء روابط الأدمن إذا لم يكن هناك مستخدم مسجل
            const adminLink = document.querySelector('.navbar-nav .nav-item a[href="admin.html"]');
            const usersLink = document.querySelector('.navbar-nav .nav-item a[href="users.html"]');
            if (adminLink && usersLink) {
                adminLink.parentElement.style.display = 'none';
                usersLink.parentElement.style.display = 'none';
            }
        }
    }
}

/* وظيفة تسجيل الخروج */
function handleLogout(e) {
    e.preventDefault();
    if (confirm("هل أنت متأكد أنك تريد تسجيل الخروج؟")) {
        currentUser = null; // مسح المستخدم الحالي
        saveCurrentUser(); // حفظ التغيير في localStorage
        alert("تم تسجيل الخروج بنجاح!");
        window.location.href = "index.html"; // إعادة توجيه للصفحة الرئيسية
    }
}

/* حذف جميع المستخدمين (باستثناء الأدمن) */
function setupUserControls() {
    let deleteUsers = document.getElementById("deleteUsers");
    if (deleteUsers) {
        deleteUsers.addEventListener("click", () => {
            if (confirm("هل أنت متأكد من حذف جميع الحسابات المسجلة (باستثناء حساب الأدمن)؟ لا يمكن التراجع عن هذا الإجراء.")) {
                users = users.filter(user => user.isAdmin); // الاحتفاظ بحساب الأدمن فقط
                saveUsers(); // حفظ التغييرات
                renderUsers(); // تحديث القائمة
                alert("تم حذف جميع الحسابات بنجاح!");
                let channel = new BroadcastChannel('userUpdates');
                channel.postMessage({ action: 'update' }); // إرسال إشارة تحديث
            }
        });
    }
}

/* تحديث الكورسات والمستخدمين تلقائيًا عبر BroadcastChannel */
function setupAutoUpdate() {
    let courseChannel = new BroadcastChannel('courseUpdates');
    let userChannel = new BroadcastChannel('userUpdates');
    courseChannel.onmessage = function(event) {
        if (event.data.action === 'update') {
            courses = JSON.parse(localStorage.getItem("courses")) || []; // إعادة تحميل الكورسات
            if (document.getElementById("courseList")) {
                renderCourses(); // تحديث الكورسات
            }
            if (document.getElementById("courseListTable")) {
                renderCourseTable(); // تحديث جدول الكورسات
            }
        }
    };
    userChannel.onmessage = function(event) {
        if (event.data.action === 'update') {
            users = JSON.parse(localStorage.getItem("users")) || []; // إعادة تحميل المستخدمين
            if (document.getElementById("userList")) {
                renderUsers(); // تحديث قائمة المستخدمين
            }
            // تحديث حالة تسجيل الدخول/الخروج في جميع الصفحات المفتوحة
            updateAuthLink();
            showWelcomeMessage();
        }
    };
}

/* إظهار رسالة الأدمن وتحميل الوظائف عند فتح الصفحة */
document.addEventListener("DOMContentLoaded", () => {
    // تحديث رابط تسجيل الدخول/الخروج عند تحميل الصفحة
    updateAuthLink();

    // عرض رسالة الأدمن في صفحتي admin.html و users.html
    const adminMessage = document.getElementById("adminMessage");
    if (adminMessage) { // التأكد من وجود العنصر قبل التعامل معه
        if (currentUser && currentUser.isAdmin) {
            adminMessage.style.display = "block";
        } else {
            adminMessage.style.display = "none"; // إخفاء الرسالة إذا لم يكن أدمن
            // إذا لم يكن أدمن، قم بإعادة توجيهه من صفحات الأدمن
            if (window.location.pathname.includes("admin.html") || window.location.pathname.includes("users.html")) {
                alert("ليس لديك صلاحية الوصول لهذه الصفحة.");
                window.location.href = "index.html";
            }
        }
    }

    // تحميل الكورسات في index و all-courses
    if (document.getElementById("courseList")) {
        renderCourses();
        showWelcomeMessage(); // عرض رسالة الترحيب
    }
    // تحميل الكورسات وإعداد النموذج في admin.html
    if (document.getElementById("courseForm")) {
        setupAdminForm();
        renderCourseTable();
    }
    // تحميل المستخدمين وإعداد أزرار التحكم في users.html
    if (document.getElementById("userList")) {
        renderUsers();
        setupUserControls();
    }
    // إعداد نموذج التسجيل
    if (document.getElementById("registerModal")) { // يتم إعداد النموذج إذا كانت النافذة موجودة
        setupRegisterForm();
    }
    // إعداد نموذج تسجيل الدخول
    if (document.getElementById("loginForm")) {
        setupLoginForm();
    }
    // إعداد نموذج التواصل
    if (document.getElementById("contactForm")) {
        setupContactForm();
    }
    // إعداد التحديث التلقائي
    setupAutoUpdate();
});
