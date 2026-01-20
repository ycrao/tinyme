// Application state management
const App = {
    token: null,
    currentPage: 1,
    perPage: 10,
    currentEditId: null,
    apiBase: '/api',
    
    init() {
        this.token = localStorage.getItem('token');
        this.bindEvents();
        
        if (this.token) {
            this.showPage('listPage');
            this.loadPageList();
        } else {
            this.showPage('loginPage');
        }
    },
    
    bindEvents() {
        // 登录表单
        document.getElementById('loginForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleLogin();
        });
        
        // 退出登录
        document.getElementById('logoutBtn').addEventListener('click', () => {
            this.handleLogout();
        });
        
        // 创建页面按钮
        document.getElementById('createPageBtn').addEventListener('click', () => {
            this.showCreatePage();
        });
        
        // 返回列表按钮
        document.getElementById('backToListBtn').addEventListener('click', () => {
            this.showPage('listPage');
        });
        
        document.getElementById('backToListBtn2').addEventListener('click', () => {
            this.showPage('listPage');
        });
        
        // 取消编辑
        document.getElementById('cancelEditBtn').addEventListener('click', () => {
            this.showPage('listPage');
        });
        
        // 页面表单提交
        document.getElementById('pageForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSavePage();
        });
        
        // 编辑当前页面
        document.getElementById('editCurrentPageBtn').addEventListener('click', () => {
            this.handleEditCurrentPage();
        });
        
        // 删除当前页面
        document.getElementById('deleteCurrentPageBtn').addEventListener('click', () => {
            this.handleDeleteCurrentPage();
        });
    },
    
    showPage(pageId) {
        document.querySelectorAll('.page').forEach(page => {
            page.classList.remove('active');
        });
        document.getElementById(pageId).classList.add('active');
    },
    
    showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    },
    
    hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    },
    
    showToast(message, duration = 3000) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, duration);
    },
    
    showError(elementId, message) {
        const errorEl = document.getElementById(elementId);
        errorEl.textContent = message;
        errorEl.classList.add('show');
        
        setTimeout(() => {
            errorEl.classList.remove('show');
        }, 5000);
    },
    
    // API request helper
    async apiRequest(endpoint, options = {}) {
        const url = this.apiBase + endpoint;
        const headers = {
            'Content-Type': 'application/json',
            ...options.headers
        };
        
        if (this.token && !options.skipAuth) {
            headers['Authorization'] = 'Bearer ' + this.token;
        }
        
        try {
            const response = await fetch(url, {
                ...options,
                headers
            });
            
            const data = await response.json();
            
            // Handle token expiration
            if (data.code === 401) {
                this.handleLogout();
                this.showToast('Session expired, please login again');
                return null;
            }
            
            return data;
        } catch (error) {
            console.error('API Error:', error);
            this.showToast('Network error, please try again');
            return null;
        }
    },
    
    // Login handler
    async handleLogin() {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            this.showError('loginError', 'Please enter email and password');
            return;
        }
        
        this.showLoading();
        
        const data = await this.apiRequest('/login', {
            method: 'POST',
            skipAuth: true,
            body: JSON.stringify({ email, password })
        });
        
        this.hideLoading();
        
        if (data && data.code === 200) {
            this.token = data.data.token;
            localStorage.setItem('token', this.token);
            this.showToast('Login successful!');
            this.showPage('listPage');
            this.loadPageList();
        } else {
            this.showError('loginError', data?.msg || 'Login failed');
        }
    },
    
    // Logout handler
    handleLogout() {
        this.token = null;
        localStorage.removeItem('token');
        this.showToast('Logged out successfully');
        this.showPage('loginPage');
        document.getElementById('loginForm').reset();
    },
    
    // Show create page
    showCreatePage() {
        this.currentEditId = null;
        document.getElementById('editPageTitle').textContent = 'New Page';
        document.getElementById('pageContent').value = '';
        this.showPage('editPage');
    },
    
    // Load page list
    async loadPageList() {
        const pageListEl = document.getElementById('pageList');
        const emptyStateEl = document.getElementById('emptyState');
        
        this.showLoading();
        
        const data = await this.apiRequest(`/pages?page=${this.currentPage}&per_page=${this.perPage}`);
        
        this.hideLoading();
        
        if (!data || data.code !== 200) {
            this.showToast('Failed to load pages');
            return;
        }
        
        const pages = data.data.data || [];
        const total = data.data.total || 0;
        
        if (pages.length === 0) {
            pageListEl.innerHTML = '';
            emptyStateEl.style.display = 'block';
        } else {
            emptyStateEl.style.display = 'none';
            pageListEl.innerHTML = pages.map(page => this.renderPageItem(page)).join('');
            
            // Bind page item click events
            document.querySelectorAll('.page-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    if (!e.target.closest('.page-item-actions')) {
                        const pageId = item.dataset.id;
                        this.viewPage(pageId);
                    }
                });
            });
            
            // Bind edit buttons
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const pageId = btn.dataset.id;
                    this.editPage(pageId);
                });
            });
            
            // Bind delete buttons
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const pageId = btn.dataset.id;
                    this.deletePage(pageId);
                });
            });
        }
        
        this.renderPagination(total);
    },
    
    // Render page item
    renderPageItem(page) {
        const preview = page.content.substring(0, 150) + (page.content.length > 150 ? '...' : '');
        
        return `
            <div class="page-item" data-id="${page.id}">
                <div class="page-item-content">${this.escapeHtml(preview)}</div>
                <div class="page-item-footer">
                    <span>Updated at ${page.updated_at}</span>
                    <div class="page-item-actions">
                        <button class="btn btn-secondary btn-edit" data-id="${page.id}">Edit</button>
                        <button class="btn btn-secondary btn-delete" data-id="${page.id}">Delete</button>
                    </div>
                </div>
            </div>
        `;
    },
    
    // Render pagination
    renderPagination(total) {
        const paginationEl = document.getElementById('pagination');
        const totalPages = Math.ceil(total / this.perPage);
        
        if (totalPages <= 1) {
            paginationEl.innerHTML = '';
            return;
        }
        
        paginationEl.innerHTML = `
            <button class="btn btn-secondary" ${this.currentPage === 1 ? 'disabled' : ''} onclick="App.prevPage()">Previous</button>
            <span class="page-info">Page ${this.currentPage} / ${totalPages}</span>
            <button class="btn btn-secondary" ${this.currentPage === totalPages ? 'disabled' : ''} onclick="App.nextPage()">Next</button>
        `;
    },
    
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.loadPageList();
        }
    },
    
    nextPage() {
        this.currentPage++;
        this.loadPageList();
    },
    
    // View page detail
    async viewPage(pageId) {
        this.showLoading();
        
        const data = await this.apiRequest(`/page/${pageId}`);
        
        this.hideLoading();
        
        if (!data || data.code !== 200) {
            this.showToast('Failed to load page');
            return;
        }
        
        const page = data.data;
        this.currentEditId = pageId;
        document.getElementById('pageContentView').textContent = page.content;
        document.getElementById('pageCreatedAt').textContent = 'Created at ' + page.created_at;
        document.getElementById('pageUpdatedAt').textContent = 'Updated at ' + page.updated_at;
        
        this.showPage('viewPage');
    },
    
    // Edit page
    async editPage(pageId) {
        this.showLoading();
        
        const data = await this.apiRequest(`/page/${pageId}`);
        
        this.hideLoading();
        
        if (!data || data.code !== 200) {
            this.showToast('Failed to load page');
            return;
        }
        
        this.currentEditId = pageId;
        document.getElementById('editPageTitle').textContent = 'Edit Page';
        document.getElementById('pageContent').value = data.data.content;
        this.showPage('editPage');
    },
    
    // Delete page
    async deletePage(pageId) {
        if (!confirm('Are you sure you want to delete this page?')) {
            return;
        }
        
        this.showLoading();
        
        const data = await this.apiRequest(`/page/${pageId}`, {
            method: 'DELETE'
        });
        
        this.hideLoading();
        
        if (data && data.code === 200) {
            this.showToast('Page deleted successfully');
            this.loadPageList();
        } else {
            this.showToast('Failed to delete page');
        }
    },
    
    // Save page
    async handleSavePage() {
        const content = document.getElementById('pageContent').value;
        
        if (!content.trim()) {
            this.showError('editError', 'Please enter page content');
            return;
        }
        
        this.showLoading();
        
        let data;
        if (this.currentEditId) {
            // Update existing page
            data = await this.apiRequest(`/page/${this.currentEditId}`, {
                method: 'PUT',
                body: JSON.stringify({ content })
            });
        } else {
            // Create new page
            data = await this.apiRequest('/page', {
                method: 'POST',
                body: JSON.stringify({ content })
            });
        }
        
        this.hideLoading();
        
        if (data && (data.code === 200 || data.code === 201)) {
            this.showToast(this.currentEditId ? 'Page updated successfully' : 'Page created successfully');
            this.showPage('listPage');
            this.loadPageList();
        } else {
            this.showError('editError', data?.msg || 'Failed to save page');
        }
    },
    
    // Edit current viewing page
    handleEditCurrentPage() {
        if (this.currentEditId) {
            this.editPage(this.currentEditId);
        }
    },
    
    // Delete current viewing page
    async handleDeleteCurrentPage() {
        if (!this.currentEditId) {
            return;
        }
        
        if (!confirm('Are you sure you want to delete this page?')) {
            return;
        }
        
        this.showLoading();
        
        const data = await this.apiRequest(`/page/${this.currentEditId}`, {
            method: 'DELETE'
        });
        
        this.hideLoading();
        
        if (data && data.code === 200) {
            this.showToast('Page deleted successfully');
            this.showPage('listPage');
            this.loadPageList();
        } else {
            this.showToast('Failed to delete page');
        }
    },
    
    // HTML escape
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
};

// Initialize after page load
document.addEventListener('DOMContentLoaded', () => {
    App.init();
});

// Global function for HTML calls
function showCreatePage() {
    App.showCreatePage();
}
