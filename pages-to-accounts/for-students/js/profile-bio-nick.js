// profile-validation.js

document.addEventListener('DOMContentLoaded', function() {
    // ==================== Bio Validation ====================
    const bioInput = document.getElementById('bioInput');
    const wordCountDisplay = document.getElementById('wordCount');
    
    if (bioInput && wordCountDisplay) {
        // Initialize word count on page load
        updateWordCount();
        
        // Update on every input
        bioInput.addEventListener('input', function() {
            updateWordCount();
            validateBio();
        });
        
        // Form submission handler
        const bioForm = document.querySelector('#editBioModal form');
        if (bioForm) {
            bioForm.addEventListener('submit', function(e) {
                if (!validateBio(true)) {
                    e.preventDefault();
                }
            });
        }
    }
    
    // ==================== Nickname Validation ====================
    const nicknameInput = document.getElementById('nicknameInput');
    
    if (nicknameInput) {
        // Initialize validation
        validateNickname();
        
        // Validate on every input
        nicknameInput.addEventListener('input', function() {
            // Automatically remove any non-letter characters
            this.value = this.value.replace(/[^A-Za-z]/g, '');
            validateNickname();
        });
        
        // Form submission handler
        const nicknameForm = document.querySelector('#nicknameModal form');
        if (nicknameForm) {
            nicknameForm.addEventListener('submit', function(e) {
                if (!validateNickname(true)) {
                    e.preventDefault();
                }
            });
        }
    }
    
    // ==================== Helper Functions ====================
    
    /**
     * Updates the word count display for bio field
     */
    function updateWordCount() {
        const text = bioInput.value.trim();
        const wordCount = text === '' ? 0 : text.split(/\s+/).length;
        wordCountDisplay.textContent = `${wordCount}/100 words`;
    }
    
    /**
     * Validates the bio field
     * @param {boolean} showAlert - Whether to show alert on validation failure
     * @return {boolean} True if valid, false otherwise
     */
    function validateBio(showAlert = false) {
        const text = bioInput.value.trim();
        const wordCount = text === '' ? 0 : text.split(/\s+/).length;
        
        if (wordCount > 100) {
            bioInput.classList.add('is-invalid');
            wordCountDisplay.classList.add('word-limit-exceeded');
            
            if (showAlert) {
                alert('Bio must be 100 words or less');
            }
            return false;
        }
        
        bioInput.classList.remove('is-invalid');
        wordCountDisplay.classList.remove('word-limit-exceeded');
        return true;
    }
    
    /**
     * Validates the nickname field
     * @param {boolean} showAlert - Whether to show alert on validation failure
     * @return {boolean} True if valid, false otherwise
     */
    function validateNickname(showAlert = false) {
        const nickname = nicknameInput.value.trim();
        
        if (nickname === '') {
            nicknameInput.classList.add('is-invalid');
            
            if (showAlert) {
                alert('Nickname cannot be empty');
            }
            return false;
        }
        
        if (!/^[A-Za-z]+$/.test(nickname)) {
            nicknameInput.classList.add('is-invalid');
            
            if (showAlert) {
                alert('Nickname can only contain letters (A-Z, a-z)');
            }
            return false;
        }
        
        if (nickname.length > 50) {
            nicknameInput.classList.add('is-invalid');
            
            if (showAlert) {
                alert('Nickname must be 50 characters or less');
            }
            return false;
        }
        
        nicknameInput.classList.remove('is-invalid');
        return true;
    }
});