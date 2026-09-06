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
    if (gradeSelect) {
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
    }

    // Tab switching
    loginTab.addEventListener('click', () => switchTab('login'));
    registerTab.addEventListener('click', () => switchTab('register'));

    function switchTab(tabName) {
        const isLogin = tabName === 'login';
        loginTab.classList.toggle('active', isLogin);
        registerTab.classList.toggle('active', !isLogin);
        loginFormContainer.style.display = isLogin ? 'block' : 'none';
        registerFormContainer.style.display = !isLogin ? 'block' : 'none';
        botLinkContainer.style.display = 'none';
        messageContainer.style.display = 'none';
    }
    
    // Show bot link form
    if (showBotLinkBtn) {
        showBotLinkBtn.addEventListener('click', () => {
            registerFormContainer.style.display = 'none';
            botLinkContainer.style.display = 'block';
            botLinkStep1.style.display = 'block';
            botLinkStep2.style.display = 'none';
        });
    }
    
    // Back to register
    if (backToRegisterBtn) {
        backToRegisterBtn.addEventListener('click', () => {
            botLinkContainer.style.display = 'none';
            registerFormContainer.style.display = 'block';
        });
    }

    function showMessage(type, title, message, redirectUrl = null) {
        messageContainer.className = type;
        formMessageTitle.textContent = title;
        formMessage.textContent = message;
        
        if (redirectUrl) {
            redirectButton.style.display = 'inline-block';
            redirectButton.href = redirectUrl;
        } else {
            redirectButton.style.display = 'none';
        }
        
        loginFormContainer.style.display = 'none';
        registerFormContainer.style.display = 'none';
        botLinkContainer.style.display = 'none';
        messageContainer.style.display = 'block';
    }

    function showError(message, container = null) {
        showMessage('error', 'خطا', message);
        setTimeout(() => {
            messageContainer.style.display = 'none';
            if (container) {
                container.style.display = 'block';
            } else if (loginTab.classList.contains('active')) {
                loginFormContainer.style.display = 'block';
            } else {
                registerFormContainer.style.display = 'block';
            }
        }, 3000);
    }

    async function handleSubmit(form, successCallback = null) {
        const button = form.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> صبر کنید...';
        
        try {
            const formData = new FormData(form);
            const response = await fetch('../api/auth.php', { 
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
                    const redirectUrl = data.redirect || 'dashboard.html';
                    showMessage('success', data.title || 'موفق', data.message, redirectUrl);
                    setTimeout(() => window.location.href = redirectUrl, 1500);
                }
            } else {
                // Check if user has bot account
                if (data.has_bot_account) {
                    showBotLinkBtn.click(); // Show bot link form
                }
                throw new Error(data.message || 'خطایی رخ داد');
            }
        } catch (error) {
            const currentContainer = botLinkContainer.style.display === 'block' ? botLinkContainer : null;
            showError(error.message, currentContainer);
        } finally {
            button.disabled = false;
            button.innerHTML = originalText;
        }
    }

    // Form submissions
    document.getElementById('formLogin').addEventListener('submit', (e) => {
        e.preventDefault();
        handleSubmit(e.target);
    });

    document.getElementById('formRegister').addEventListener('submit', (e) => {
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
                
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    // Show step 2
                    botLinkStep1.style.display = 'none';
                    botLinkStep2.style.display = 'block';
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
                
                const response = await fetch('../api/auth.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    const redirectUrl = data.redirect || 'dashboard.html';
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
