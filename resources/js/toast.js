// resources/js/toast.js

window.showToast = function(title, message, type = 'info', redirectUrl = null) {
    // 1. Create the container
    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    
    // Default border color (Blue)
    let borderColor = '#0077b6';
    if (type === 'success') borderColor = '#10b981'; // Green
    if (type === 'warning') borderColor = '#f59e0b'; // Orange
    if (type === 'error') borderColor = '#ef4444';   // Red

    // 2. Design and CSS
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #ffffff;
        color: #1f2937;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-left: 6px solid ${borderColor};
        font-family: 'Poppins', Arial, sans-serif;
        z-index: 9999;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        cursor: ${redirectUrl ? 'pointer' : 'default'};
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        max-width: 350px;
    `;

    // 3. HTML content
    toast.innerHTML = `
        <div style="font-size: 24px; margin-top: 2px;">🔔</div>
        <div style="flex: 1;">
            <div style="font-weight: 700; color: #023e8a; font-size: 15px; margin-bottom: 4px;">${title}</div>
            <div style="font-size: 13px; color: #4b5563; line-height: 1.4;">${message}</div>
        </div>
        <div style="font-size: 18px; color: #9ca3af; cursor: pointer; padding: 0 5px;" class="toast-close">&times;</div>
    `;

    // 4. Append to body
    document.body.appendChild(toast);

    // 5. Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);

    // 6. Close button logic
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', function(e) {
        e.stopPropagation(); 
        closeToast();
    });

    // 7. Function to close the toast
    function closeToast() {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 400);
    }

    // 8. Click to redirect
    if (redirectUrl) {
        toast.addEventListener('click', function() {
            window.location.href = redirectUrl;
        });
    }

    // 9. Auto close after 12 seconds
     setTimeout(closeToast, 30000);
}