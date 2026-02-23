/**
 * Custom JavaScript for Onjarandria Portfolio Admin
 * Handles Turbo events and custom admin functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    initTooltips();
    
    // Initialize popovers
    initPopovers();
    
    // Handle form submissions with Turbo
    handleTurboForms();
});

// Turbo: Render event
document.addEventListener('turbo:render', function() {
    // Re-initialize components after Turbo navigation
    initTooltips();
    initPopovers();
    handleTurboForms();
});

// Turbo: Before fetch request
document.addEventListener('turbo:before-fetch-request', function(event) {
    // Show loading indicator
    showLoadingIndicator();
});

// Turbo: After fetch request
document.addEventListener('turbo:after-fetch-request', function() {
    // Hide loading indicator
    hideLoadingIndicator();
});

// Turbo: Frame render
document.addEventListener('turbo:frame-render', function() {
    // Re-initialize components inside frames
    initTooltips();
    initPopovers();
});

/**
 * Initialize Bootstrap tooltips
 */
function initTooltips() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

/**
 * Initialize Bootstrap popovers
 */
function initPopovers() {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    popoverTriggerList.forEach(function(popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl);
    });
}

/**
 * Handle forms with Turbo
 */
function handleTurboForms() {
    const forms = document.querySelectorAll('form[data-turbo="true"]');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const submitButton = form.querySelector('button[type="submit"]');
            const loadingDiv = form.querySelector('.loading');
            
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="loading-spinner"></span> Envoi en cours...';
            }
            
            if (loadingDiv) {
                loadingDiv.style.display = 'block';
            }
        });
    });
}

/**
 * Show loading indicator
 */
function showLoadingIndicator() {
    // Add loading class to body
    document.body.classList.add('turbo-loading');
}

/**
 * Hide loading indicator
 */
function hideLoadingIndicator() {
    // Remove loading class from body
    document.body.classList.remove('turbo-loading');
}

/**
 * Confirm delete action
 */
function confirmDelete(message) {
    return confirm(message || 'Êtes-vous sûr de vouloir supprimer cet élément ?');
}

/**
 * Toggle element visibility
 */
function toggleElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = element.style.display === 'none' ? 'block' : 'none';
    }
}

/**
 * Preview image before upload
 */
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Export functions for global access
window.OnjarandriaAdmin = {
    initTooltips: initTooltips,
    initPopovers: initPopovers,
    confirmDelete: confirmDelete,
    toggleElement: toggleElement,
    previewImage: previewImage
};
