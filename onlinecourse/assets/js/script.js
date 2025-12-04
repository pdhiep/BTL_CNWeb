// ===== FORM VALIDATION =====
function validateEmail(email) {
	const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	return re.test(email);
}

function validatePassword(password) {
	return password.length >= 6;
}

function showError(input, message) {
	const wrapper = input.parentElement;
	const error = wrapper.querySelector('.error-message');
	if (error) {
		error.textContent = message;
		error.style.display = 'block';
	} else {
		const errorDiv = document.createElement('div');
		errorDiv.className = 'error-message';
		errorDiv.textContent = message;
		errorDiv.style.color = '#dc3545';
		errorDiv.style.fontSize = '12px';
		errorDiv.style.marginTop = '4px';
		wrapper.appendChild(errorDiv);
	}
	input.style.borderColor = '#dc3545';
}

function clearError(input) {
	const wrapper = input.parentElement;
	const error = wrapper.querySelector('.error-message');
	if (error) {
		error.style.display = 'none';
	}
	input.style.borderColor = '#ddd';
}

// ===== FILE UPLOAD PREVIEW =====
function previewFile(input, previewId) {
	const file = input.files[0];
	if (!file) return;

	// Validate file size (max 5MB)
	const maxSize = 5 * 1024 * 1024;
	if (file.size > maxSize) {
		alert('Kích thước file không được vượt quá 5MB');
		input.value = '';
		return;
	}

	const preview = document.getElementById(previewId);
	if (!preview) return;

	if (file.type.startsWith('image/')) {
		const reader = new FileReader();
		reader.onload = function(e) {
			preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px;">`;
		};
		reader.readAsDataURL(file);
	} else {
		preview.innerHTML = `<div style="padding: 20px; text-align: center; background: #f5f5f5; border-radius: 8px;">
			<p style="margin: 0; font-size: 14px;">📄 ${file.name}</p>
			<p style="margin: 4px 0 0 0; color: #999; font-size: 12px;">${(file.size / 1024).toFixed(2)} KB</p>
		</div>`;
	}
}

// ===== AVATAR UPLOAD =====
function setupAvatarUpload() {
	const avatarInput = document.getElementById('avatar-input');
	const avatarPreview = document.getElementById('avatar-preview');

	if (!avatarInput) return;

	avatarInput.addEventListener('change', function() {
		previewFile(this, 'avatar-preview');
	});

	// Drag and drop
	if (avatarPreview) {
		avatarPreview.addEventListener('dragover', (e) => {
			e.preventDefault();
			avatarPreview.style.background = '#f0f0f0';
		});

		avatarPreview.addEventListener('dragleave', () => {
			avatarPreview.style.background = '#fff';
		});

		avatarPreview.addEventListener('drop', (e) => {
			e.preventDefault();
			avatarPreview.style.background = '#fff';
			if (e.dataTransfer.files.length) {
				avatarInput.files = e.dataTransfer.files;
				const event = new Event('change', { bubbles: true });
				avatarInput.dispatchEvent(event);
			}
		});
	}
}

// ===== DOCUMENT UPLOAD =====
function setupDocumentUpload() {
	const docInput = document.getElementById('document-input');
	const docPreview = document.getElementById('document-preview');

	if (!docInput) return;

	docInput.addEventListener('change', function() {
		const files = this.files;
		const container = document.getElementById('documents-list');

		if (!container) return;

		Array.from(files).forEach((file, index) => {
			// Validate file size
			const maxSize = 50 * 1024 * 1024; // 50MB for documents
			if (file.size > maxSize) {
				alert(`File ${file.name} quá lớn (tối đa 50MB)`);
				return;
			}

			const fileDiv = document.createElement('div');
			fileDiv.className = 'document-item';
			fileDiv.style.cssText = `
				background: white;
				padding: 12px 16px;
				margin: 8px 0;
				border: 1px solid #ddd;
				border-radius: 6px;
				display: flex;
				align-items: center;
				gap: 12px;
				justify-content: space-between;
			`;

			const fileInfo = document.createElement('div');
			fileInfo.style.cssText = 'flex: 1;';
			fileInfo.innerHTML = `
				<p style="margin: 0; font-weight: 500; font-size: 14px;">📄 ${file.name}</p>
				<p style="margin: 4px 0 0 0; color: #999; font-size: 12px;">${(file.size / 1024).toFixed(2)} KB</p>
			`;

			const removeBtn = document.createElement('button');
			removeBtn.type = 'button';
			removeBtn.textContent = '✕ Xóa';
			removeBtn.style.cssText = `
				padding: 6px 12px;
				background: #dc3545;
				color: white;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				font-size: 12px;
				font-weight: 500;
			`;

			removeBtn.addEventListener('click', () => {
				fileDiv.remove();
			});

			fileDiv.appendChild(fileInfo);
			fileDiv.appendChild(removeBtn);
			container.appendChild(fileDiv);
		});

		this.value = '';
	});
}

// ===== FORM SUBMISSION =====
function setupFormValidation() {
	// Registration form
	const registerForm = document.querySelector('form[action*="register"]');
	if (registerForm) {
		registerForm.addEventListener('submit', function(e) {
			const emailInput = this.querySelector('input[type="email"]');
			const passwordInput = this.querySelector('input[type="password"]');
			const nameInput = this.querySelector('input[name="fullname"]');

			let isValid = true;

			if (nameInput && nameInput.value.trim() === '') {
				showError(nameInput, 'Vui lòng nhập tên đầy đủ');
				isValid = false;
			} else if (nameInput) {
				clearError(nameInput);
			}

			if (emailInput && !validateEmail(emailInput.value)) {
				showError(emailInput, 'Email không hợp lệ');
				isValid = false;
			} else if (emailInput) {
				clearError(emailInput);
			}

			if (passwordInput && !validatePassword(passwordInput.value)) {
				showError(passwordInput, 'Mật khẩu phải có ít nhất 6 ký tự');
				isValid = false;
			} else if (passwordInput) {
				clearError(passwordInput);
			}

			if (!isValid) {
				e.preventDefault();
			}
		});
	}

	// Login form
	const loginForm = document.querySelector('form[action*="login"]');
	if (loginForm) {
		loginForm.addEventListener('submit', function(e) {
			const emailInput = this.querySelector('input[type="email"]');
			const passwordInput = this.querySelector('input[type="password"]');

			let isValid = true;

			if (emailInput && emailInput.value.trim() === '') {
				showError(emailInput, 'Vui lòng nhập email');
				isValid = false;
			} else if (emailInput) {
				clearError(emailInput);
			}

			if (passwordInput && passwordInput.value.trim() === '') {
				showError(passwordInput, 'Vui lòng nhập mật khẩu');
				isValid = false;
			} else if (passwordInput) {
				clearError(passwordInput);
			}

			if (!isValid) {
				e.preventDefault();
			}
		});
	}
}

// ===== MODAL DIALOGS =====
function openModal(modalId) {
	const modal = document.getElementById(modalId);
	if (modal) {
		modal.style.display = 'flex';
		document.body.style.overflow = 'hidden';
	}
}

function closeModal(modalId) {
	const modal = document.getElementById(modalId);
	if (modal) {
		modal.style.display = 'none';
		document.body.style.overflow = 'auto';
	}
}

// Setup modal close buttons
function setupModals() {
	document.querySelectorAll('[data-modal-close]').forEach(btn => {
		btn.addEventListener('click', function() {
			const modal = this.closest('[data-modal]');
			if (modal) {
				closeModal(modal.id);
			}
		});
	});

	// Close on background click
	document.querySelectorAll('[data-modal]').forEach(modal => {
		modal.addEventListener('click', function(e) {
			if (e.target === this) {
				closeModal(this.id);
			}
		});
	});
}

// ===== DYNAMIC CONTENT LOADING =====
function loadContent(url, containerId) {
	const container = document.getElementById(containerId);
	if (!container) return;

	fetch(url)
		.then(response => response.text())
		.then(html => {
			container.innerHTML = html;
		})
		.catch(error => {
			console.error('Error loading content:', error);
			container.innerHTML = '<p style="color: #dc3545;">Lỗi khi tải dữ liệu</p>';
		});
}

// ===== PROGRESS BAR =====
function updateProgressBar(progress) {
	const progressBar = document.querySelector('.progress-bar');
	if (progressBar) {
		progressBar.style.width = progress + '%';
		progressBar.textContent = progress + '%';
	}
}

// ===== SEARCH WITH DEBOUNCE =====
function setupSearch() {
	const searchInputs = document.querySelectorAll('input[type="text"][placeholder*="ìm"]');
	
	searchInputs.forEach(input => {
		let timeout;
		input.addEventListener('input', function() {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				// Form auto-submit or trigger search
				const form = this.closest('form');
				if (form) {
					form.submit();
				}
			}, 300);
		});
	});
}

// ===== CONFIRM ACTIONS =====
function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
	return confirm(message);
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
	setupAvatarUpload();
	setupDocumentUpload();
	setupFormValidation();
	setupModals();
	setupSearch();

	// Flash message auto-dismiss
	const flashMessages = document.querySelectorAll('.alert');
	flashMessages.forEach(msg => {
		setTimeout(() => {
			msg.style.opacity = '0';
			msg.style.transition = 'opacity 0.3s ease';
			setTimeout(() => msg.remove(), 300);
		}, 5000);
	});

	// Smooth scroll
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			e.preventDefault();
			const target = document.querySelector(this.getAttribute('href'));
			if (target) {
				target.scrollIntoView({ behavior: 'smooth' });
			}
		});
	});
});
