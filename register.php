<?php $base = '../'; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ورود و ثبت نام | آموزشگاه فامو</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/output.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/register.css">
</head>

<body class="bg-[#11223C]/60 bg-blur flex items-center justify-center min-h-screen py-5">
    <div class="flex w-full max-w-5xl min-h-[650px] bg-[#d9dce2] rounded-2xl shadow-2xl overflow-hidden mx-5">
        <!-- Form Section -->
        <div class="flex-1 p-10 flex flex-col justify-center">
            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-[#445D84]">به فامو خوش آمدید</h1>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center mb-8 bg-[#f9f7f3] rounded-full p-1">
                <button id="loginTab"
                    class="tab-btn active flex-1 py-3 px-6 rounded-full font-semibold transition-all duration-300">وارد
                    شدن
                </button>
                <button id="registerTab"
                    class="tab-btn flex-1 py-3 px-6 rounded-full font-semibold transition-all duration-300">ثبت
                    نام
                </button>
            </div>

            <!-- Form Container -->
            <div class="form-container relative overflow-hidden">
                <div id="formErrorSummary" class="hidden mb-4 rounded-xl border-2 border-red-400 bg-red-50 p-4 text-red-700" role="alert" tabindex="-1"></div>
                <!-- Login Form -->
                <div id="loginFormContainer">
                    <p class="text-center text-gray-600 mb-6">برای ورود، اطلاعات خود را وارد کنید.</p>
                    <form id="formLogin" novalidate>
                        <input type="hidden" name="action" value="login">
                        <div class="input-group">
                            <label for="loginPhone" class="sr-only">شماره موبایل</label>
                            <input type="tel" name="phone" id="loginPhone" placeholder="شماره موبایل"
                                pattern="09[0-9]{9}" aria-describedby="loginPhoneErr" data-error-required="لطفاً شماره موبایل را وارد کنید"
                                data-error-pattern="شماره موبایل باید با 09 شروع شود و 11 رقم باشد">
                            <svg class="icon icon--md input-icon" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-phone" />
                            </svg>
                            <span class="error-message" id="loginPhoneErr" aria-live="polite"></span>
                        </div>
                        <div class="input-group has-password">
                            <label for="loginPassword" class="sr-only">رمز عبور</label>
                            <input type="password" id="loginPassword" name="password" placeholder="رمز عبور"
                                minlength="4" aria-describedby="loginPassErr" data-error-required="لطفاً رمز عبور را وارد کنید"
                                data-error-minlength="رمز عبور باید حداقل ۴ کاراکتر باشد">
                            <svg class="icon icon--md input-icon" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-lock" />
                            </svg>
                            <button type="button" class="password-toggle"
                                onclick="togglePasswordVisibility('loginPassword', this)" title="نمایش رمز عبور">
                                <img src="<?php echo $base; ?>assets/svg/eye-closed.svg" alt=""
                                    class="password-toggle-icon w-5 h-5" width="20" height="20">
                            </button>
                            <span class="error-message" id="loginPassErr" aria-live="polite"></span>
                        </div>
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-[#445D84] to-[#5a779e] text-white font-semibold text-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02]">
                            <svg class="icon icon--sm inline-block ml-2" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-login" />
                            </svg> ورود
                        </button>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="registerFormContainer" class="hidden">
                    <p class="text-center text-gray-600 mb-6">برای ثبت‌نام، اطلاعات خود را وارد کنید.</p>
                    <form id="formRegister" novalidate>
                        <input type="hidden" name="action" value="register">

                        <div class="input-group">
                            <label for="registerFullName" class="sr-only">نام و نام خانوادگی</label>
                            <input type="text" name="full_name" id="registerFullName" placeholder="نام و نام خانوادگی"
                                aria-describedby="regNameErr" data-error-required="لطفاً نام و نام خانوادگی را وارد کنید">
                            <svg class="icon icon--md input-icon" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-user" />
                            </svg>
                            <span class="error-message" id="regNameErr" aria-live="polite"></span>
                        </div>

                        <div class="input-group">
                            <label for="registerPhone" class="sr-only">شماره موبایل</label>
                            <input type="tel" name="phone" id="registerPhone" placeholder="شماره موبایل (09...)"
                                pattern="09[0-9]{9}" aria-describedby="regPhoneErr" data-error-required="لطفاً شماره موبایل را وارد کنید"
                                data-error-pattern="شماره موبایل باید با 09 شروع شود و 11 رقم باشد">
                            <svg class="icon icon--md input-icon" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-phone" />
                            </svg>
                            <span class="error-message" id="regPhoneErr" aria-live="polite"></span>
                        </div>

                        <div class="input-group has-password">
                            <label for="registerPassword" class="sr-only">رمز عبور</label>
                            <input type="password" id="registerPassword" name="password"
                                placeholder="رمز عبور (حداقل ۴ کاراکتر)" minlength="4"
                                aria-describedby="regPassErr"
                                data-error-required="لطفاً رمز عبور را وارد کنید"
                                data-error-minlength="رمز عبور باید حداقل ۴ کاراکتر باشد">
                            <svg class="icon icon--md input-icon" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-lock" />
                            </svg>
                            <button type="button" class="password-toggle"
                                onclick="togglePasswordVisibility('registerPassword', this)" title="نمایش رمز عبور">
                                <img src="<?php echo $base; ?>assets/svg/eye-closed.svg" alt=""
                                    class="password-toggle-icon w-5 h-5" width="20" height="20">
                            </button>
                            <span class="error-message" id="regPassErr" aria-live="polite"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-1">
                            <div class="input-group">
                                <label for="registerGrade" class="sr-only">پایه تحصیلی</label>
                                <select name="grade" id="registerGrade"
                                    aria-describedby="regGradeErr"
                                    data-error-required="لطفاً پایه تحصیلی را انتخاب کنید">
                                    <option value="" disabled selected>پایه</option>
                                    <option value="7">هفتم</option>
                                    <option value="8">هشتم</option>
                                    <option value="9">نهم</option>
                                    <option value="10">دهم</option>
                                    <option value="11">یازدهم</option>
                                    <option value="12">دوازدهم</option>
                                </select>
                                <svg class="icon icon--md input-icon" aria-hidden="true">
                                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-school" />
                                </svg>
                                <svg class="icon icon--sm select-arrow" aria-hidden="true">
                                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-down" />
                                </svg>
                                <span class="error-message" id="regGradeErr" aria-live="polite"></span>
                            </div>
                            <div class="input-group" id="fieldContainer">
                                <label for="registerField" class="sr-only">رشته تحصیلی</label>
                                <select name="field" id="registerField"
                                    aria-describedby="regFieldErr"
                                    data-error-required="لطفاً رشته تحصیلی را انتخاب کنید">
                                    <option value="" disabled selected>رشته</option>
                                    <option value="تجربی">تجربی</option>
                                    <option value="ریاضی">ریاضی</option>
                                    <option value="انسانی">انسانی</option>
                                </select>
                                <svg class="icon icon--md input-icon" aria-hidden="true">
                                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-book" />
                                </svg>
                                <svg class="icon icon--sm select-arrow" aria-hidden="true">
                                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-down" />
                                </svg>
                                <span class="error-message" id="regFieldErr" aria-live="polite"></span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-[#445D84] to-[#5a779e] text-white font-semibold text-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] mt-4">
                            <svg class="icon icon--sm inline-block ml-2" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-user-plus" />
                            </svg> ثبت نام
                        </button>
                    </form>
                </div>

                <!-- Link to Bot Users -->
                <div class="mt-6 text-center hidden">
                    <p class="text-gray-500 text-sm mb-2">قبلاً از ربات تلگرام ثبت‌نام کرده‌اید؟</p>
                    <button id="showBotLinkBtn" class="text-[#445D84] font-semibold hover:underline">
                        <svg class="icon icon--sm inline-block ml-1" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-telegram" />
                        </svg> اتصال حساب ربات به سایت
                    </button>
                </div>
            </div>

            <!-- Back Link -->
            <div class="text-center mt-3 pt-6">
                <a href="../index.php" class="text-gray-600 font-medium hover:text-[#445D84] transition duration-300">
                    <svg class="icon icon--sm inline-block ml-2" aria-hidden="true">
                        <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                    </svg> بازگشت به صفحه اصلی
                </a>
            </div>
        </div>

        <!-- Branding Section -->
        <div
            class="hidden lg:flex flex-1 bg-gradient-to-br from-[#11223C] to-[#05387e] text-white justify-center items-center text-center p-10">
            <div class="branding-content">
                <a href="../index.php" class="inline-block mb-3">
                    <img src="<?php echo $base; ?>assets/images/logo.png" alt="لوگوی آموزشگاه فامو" class="h-16 mx-auto">
                </a>
                <h2 class="text-3xl font-bold mb-5 text-white">آینده تحصیلی خود را با فامو بسازید</h2>
                <p class="text-lg text-white/90">با پیوستن به جمع دانش‌آموزان ما، قدم در راهuccess بگذارید.</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility function
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('.password-toggle-icon');
            if (!icon) return;
            if (input.type === 'password') {
                input.type = 'text';
                icon.src = '../assets/svg/eye-open.svg';
                icon.title = 'مخفی کردن رمز عبور';
            } else {
                input.type = 'password';
                icon.src = '../assets/svg/eye-closed.svg';
                icon.title = 'نمایش رمز عبور';
            }
        }

        // Custom form validation
        function validateField(input) {
            const inputGroup = input.closest('.input-group');
            const errorMessage = inputGroup.querySelector('.error-message');
            let isValid = true;
            let message = '';

            // Reset state
            inputGroup.classList.remove('error', 'success');

            // Check if empty
            if (!input.value.trim()) {
                isValid = false;
                message = input.dataset.errorRequired || 'این فیلد الزامی است';
            }
            // Check pattern
            else if (input.pattern && !new RegExp('^' + input.pattern + '$').test(input.value)) {
                isValid = false;
                message = input.dataset.errorPattern || 'فرمت وارد شده صحیح نیست';
            }
            // Check minlength
            else if (input.minLength > 0 && input.value.length < input.minLength) {
                isValid = false;
                message = input.dataset.errorMinlength || `حداقل ${input.minLength} کاراکتر وارد کنید`;
            }
            // Check select
            else if (input.tagName === 'SELECT' && !input.value) {
                isValid = false;
                message = input.dataset.errorRequired || 'لطفاً یک گزینه انتخاب کنید';
            }

            if (!isValid) {
                inputGroup.classList.add('error');
                errorMessage.textContent = message;
            } else {
                inputGroup.classList.add('success');
                errorMessage.textContent = '';
            }

            return isValid;
        }

        function validateForm(form) {
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select');
            let isFormValid = true;
            let firstInvalidField = null;

            inputs.forEach(input => {
                // Skip hidden containers
                if (input.closest('[style*="display: none"]') || input.closest('[style*="display:none"]')) {
                    return;
                }

                const isValid = validateField(input);
                if (!isValid && isFormValid) {
                    isFormValid = false;
                    firstInvalidField = input;
                }
            });

            // Show error summary and move focus for screen reader / keyboard users
            const summary = document.getElementById('formErrorSummary');
            if (!isFormValid && firstInvalidField) {
                if (summary) {
                    const invalid = Array.from(form.querySelectorAll('.input-group.error input, .input-group.error select'));
                    const items = invalid.map(el => {
                        const msg = el.closest('.input-group').querySelector('.error-message').textContent;
                        const id = el.id ? ` href="#${el.id}"` : '';
                        return `<li><a${id} class="underline font-semibold">${msg}</a></li>`;
                    }).join('');
                    summary.innerHTML = `<p class="font-bold mb-2">${invalid.length} مورد نیاز به اصلاح است:</p><ul class="list-disc pr-5 space-y-1">${items}</ul>`;
                    summary.classList.remove('hidden');
                    summary.focus();
                } else {
                    firstInvalidField.focus();
                }
            } else if (summary) {
                summary.classList.add('hidden');
                summary.innerHTML = '';
            }

            return isFormValid;
        }

        // Add real-time validation on blur
        document.querySelectorAll('.input-group input, .input-group select').forEach(input => {
            input.addEventListener('blur', function () {
                if (this.value.trim()) {
                    validateField(this);
                }
            });
            // Clear error on input
            input.addEventListener('input', function () {
                const inputGroup = this.closest('.input-group');
                if (inputGroup.classList.contains('error')) {
                    inputGroup.classList.remove('error');
                    inputGroup.querySelector('.error-message').textContent = '';
                }
            });
        });

        // Override form submissions
        document.querySelectorAll('form[novalidate]').forEach(form => {
            form.addEventListener('submit', function (e) {
                if (!validateForm(this)) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });
        });

        // Update message icon dynamically
        document.addEventListener('DOMContentLoaded', function () {
            const messageContainer = document.getElementById('messageContainer');
            const messageIcon = messageContainer?.querySelector('.message-icon');

            if (messageIcon) {
                // Observer to watch for class changes
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.attributeName === 'class') {
                            const isSuccess = messageContainer.classList.contains('success');
                            const isError = messageContainer.classList.contains('error');

                            if (isSuccess) {
                                messageIcon.innerHTML = '<svg class="icon" style="width: 3rem; height: 3rem;" aria-hidden="true"><use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-check-circle"/></svg>';
                            } else if (isError) {
                                messageIcon.innerHTML = '<svg class="icon" style="width: 3rem; height: 3rem;" aria-hidden="true"><use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-alert-circle"/></svg>';
                            }
                        }
                    });
                });
                observer.observe(messageContainer, { attributes: true });
            }
        });
    </script>
    <script src="<?php echo $base; ?>assets/pages/register/js/auth.js"></script>
</body>
</html>