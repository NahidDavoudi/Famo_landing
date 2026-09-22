// auth.js - Famo Academy (Password-based Auth + Bot Link)
document.addEventListener('DOMContentLoaded', () => {
    // Elements
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginFormContainer = document.getElementById('loginFormContainer');
    const registerFormContainer = document.getElementById('registerFormContainer');
    const botLinkContainer = document.getElementById('botLinkContainer');
    const messageContainer = document.getElementById('messageContainer');
    const formMessageTitle = document.getElementById('formMessageTitle');
    const formMessage = document.getElementById('formMessage');
    const redirectButton = document.getElementById('redirectButton');

    // Bot link elements
    const showBotLinkBtn = document.getElementById('showBotLinkBtn');
    const backToRegisterBtn = document.getElementById('backToRegisterBtn');
    const botLinkStep1 = document.getElementById('botLinkStep1');
    const botLinkStep2 = document.getElementById('botLinkStep2');

    // Grade/Field handling
    const gradeSelect = document.querySelector('#formRegister select[name="grade"]');
    const fieldContainer = document.getElementById('fieldContainer');
    const fieldSelect = document.querySelector('#formRegister select[name="field"]');

    // Handle grade change - hide field for grades 7-9
    if (gradeSelect && fieldContainer && fieldSelect) {
        gradeSelect.addEventListener('change', () => {
            const grade = parseInt(gradeSelect.value);
            if (grade <= 9) {
                fieldContainer.style.display = 'none';
                fieldSelect.removeAttribute('required');
                fieldSelect.value = '';
            } else {
                fieldContainer.style.display = 'block';
                fieldSelect.setAttribute('required', '');
            }
        });
        // Apply initial state if a grade is pre-selected
        if (gradeSelect.value && parseInt(gradeSelect.value) <= 9) {
            fieldContainer.style.display = 'none';
            fieldSelect.value = '';
        }
    }

    // Tab switching (guarded: register.php has no bot/message containers)
    if (loginTab) loginTab.addEventListener('click', () => switchTab('login'));
    if (registerTab) registerTab.addEventListener('click', () => switchTab('register'));

    function switchTab(tabName) {
        const isLogin = tabName === 'login';
        if (loginTab) loginTab.classList.toggle('active', isLogin);
        if (registerTab) registerTab.classList.toggle('active', !isLogin);
        if (loginFormContainer) loginFormContainer.style.display = isLogin ? 'block' : 'none';
        if (registerFormContainer) registerFormContainer.style.display = !isLogin ? 'block' : 'none';
        if (botLinkContainer) botLinkContainer.style.display = 'none';
        if (messageContainer) messageContainer.style.display = 'none';
    }

    // Show bot link form
    if (showBotLinkBtn && registerFormContainer && botLinkContainer) {
        showBotLinkBtn.addEventListener('click', () => {
            registerFormContainer.style.display = 'none';
            botLinkContainer.style.display = 'block';
            if (botLinkStep1) botLinkStep1.style.display = 'block';
            if (botLinkStep2) botLinkStep2.style.display = 'none';
        });
    }

    // Back to register
    if (backToRegisterBtn && botLinkContainer && registerFormContainer) {
        backToRegisterBtn.addEventListener('click', () => {
            botLinkContainer.style.display = 'none';
            registerFormContainer.style.display = 'block';
        });
    }

    function showMessage(type, title, message, redirectUrl = null) {
        // Fallback to inline summary / alert when messageContainer is absent (register.php)
        if (!messageContainer) {
            const summary = document.getElementById('formErrorSummary');
            if (summary) {
                summary.classList.remove('hidden');
                summary.textContent = (title ? title + ': ' : '') + message;
                summary.focus();
            } else {
                alert(message);
            }
            if (redirectUrl) {
                setTimeout(() => window.location.href = redirectUrl, 1500);
            }
            return;
        }
        messageContainer.className = type;
        if (formMessageTitle) formMessageTitle.textContent = title;
        if (formMessage) formMessage.textContent = message;

        if (redirectButton) {
            if (redirectUrl) {
                redirectButton.style.display = 'inline-block';
                redirectButton.href = redirectUrl;
            } else {
                redirectButton.style.display = 'none';
            }
        }

        if (loginFormContainer) loginFormContainer.style.display = 'none';
        if (registerFormContainer) registerFormContainer.style.display = 'none';
        if (botLinkContainer) botLinkContainer.style.display = 'none';
        messageContainer.style.display = 'block';
    }

    function showError(message, container = null) {
        // If no messageContainer, show inline via formErrorSummary
        if (!messageContainer) {
            const summary = document.getElementById('formErrorSummary');
            if (summary) {
                summary.classList.remove('hidden');
                summary.textContent = message;
                summary.focus();
                setTimeout(() => {
                    summary.classList.add('hidden');
                    summary.textContent = '';
                }, 4000);
            } else {
                alert(message);
            }
            return;
        }
        showMessage('error', 'خطا', message);
        setTimeout(() => {
            messageContainer.style.display = 'none';
            if (container) {
                container.style.display = 'block';
            } else if (loginTab && loginTab.classList.contains('active')) {
                if (loginFormContainer) loginFormContainer.style.display = 'block';
            } else {
                if (registerFormContainer) registerFormContainer.style.display = 'block';
            }
        }, 3000);
    }

    async function handleSubmit(form, successCallback = null) {
        const button = form.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';
        if (button) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> صبر کنید...';
        }

        try {
            // Respect inline validateForm() from register.php if present
            if (typeof validateForm === 'function') {
                if (!validateForm(form)) return;
            }
            const formData = new FormData(form);
            const response = await fetch('api/auth.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('خطای شبکه یا سرور');
            }

            const data = await response.json();

            if (data.status === 'success') {
                if (successCallback) {
                    successCallback(data);
                } else {
                    const redirectUrl = data.redirect || 'dashboard.php';
                    showMessage('success', data.title || 'موفق', data.message, redirectUrl);
                    setTimeout(() => window.location.href = redirectUrl, 1500);
                }
            } else {
                // Check if user has bot account
                if (data.has_bot_account && showBotLinkBtn) {
                    showBotLinkBtn.click(); // Show bot link form
                }
                throw new Error(data.message || 'خطایی رخ داد');
            }
        } catch (error) {
            const currentContainer = (botLinkContainer && botLinkContainer.style.display === 'block') ? botLinkContainer : null;
            showError(error.message, currentContainer);
        } finally {
            if (button) {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }
    }

    // Form submissions
    const formLogin = document.getElementById('formLogin');
    if (formLogin) formLogin.addEventListener('submit', (e) => {
        e.preventDefault();
        handleSubmit(e.target);
    });

    const formRegister = document.getElementById('formRegister');
    if (formRegister) formRegister.addEventListener('submit', (e) => {
        e.preventDefault();
        handleSubmit(e.target);
    });

    // Bot link - Step 1: Send verification code
    const formBotLink = document.getElementById('formBotLink');
    if (formBotLink) {
        formBotLink.addEventListener('submit', async (e) => {
            e.preventDefault();
            const button = e.target.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> در حال ارسال...';

            try {
                const formData = new FormData(e.target);
                formData.append('action', 'send_verify_code');

                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    // Show step 2
                    if (botLinkStep1) botLinkStep1.style.display = 'none';
                    if (botLinkStep2) botLinkStep2.style.display = 'block';
                } else {
                    throw new Error(data.message || 'خطا در ارسال کد');
                }
            } catch (error) {
                showError(error.message, botLinkContainer);
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
    }

    // Bot link - Step 2: Verify code
    const formVerifyCode = document.getElementById('formVerifyCode');
    if (formVerifyCode) {
        formVerifyCode.addEventListener('submit', async (e) => {
            e.preventDefault();
            const button = e.target.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> در حال تایید...';

            try {
                const formData = new FormData(e.target);
                formData.append('action', 'verify_code');

                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    const redirectUrl = data.redirect || 'dashboard.php';
                    showMessage('success', data.title || 'موفق', data.message, redirectUrl);
                    setTimeout(() => window.location.href = redirectUrl, 1500);
                } else {
                    throw new Error(data.message || 'خطا در تایید کد');
                }
            } catch (error) {
                showError(error.message, botLinkContainer);
            } finally {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        });
    }
});
