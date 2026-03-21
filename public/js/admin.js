/**
 * NJ Car Rentals - Admin JavaScript
 * Administrative functions and dashboard enhancements
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== DASHBOARD CHARTS =====
    const initCharts = () => {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: [120000, 190000, 150000, 250000, 220000, 300000, 280000],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Vehicle Status Chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Available', 'Rented', 'Maintenance', 'Sold'],
                    datasets: [{
                        data: [12, 8, 3, 5],
                        backgroundColor: [
                            '#28a745',
                            '#007bff',
                            '#ffc107',
                            '#6c757d'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    };
    
    // Load Chart.js if needed
    if (typeof Chart !== 'undefined') {
        initCharts();
    } else {
        // Load Chart.js dynamically if not loaded
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = initCharts;
        document.head.appendChild(script);
    }
    
    // ===== DATA TABLES ENHANCEMENT =====
    const enhanceTables = () => {
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(table => {
            // Add search functionality
            const searchInput = table.parentNode.querySelector('.table-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
            
            // Add sort functionality
            const headers = table.querySelectorAll('thead th[data-sort]');
            headers.forEach(header => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', function() {
                    const columnIndex = this.cellIndex;
                    const rows = Array.from(table.querySelectorAll('tbody tr'));
                    const isAsc = this.classList.contains('sort-asc');
                    
                    // Remove sort classes from all headers
                    headers.forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
                    
                    // Toggle sort direction
                    if (isAsc) {
                        this.classList.add('sort-desc');
                        rows.sort((a, b) => {
                            const aVal = a.cells[columnIndex].textContent;
                            const bVal = b.cells[columnIndex].textContent;
                            return bVal.localeCompare(aVal);
                        });
                    } else {
                        this.classList.add('sort-asc');
                        rows.sort((a, b) => {
                            const aVal = a.cells[columnIndex].textContent;
                            const bVal = b.cells[columnIndex].textContent;
                            return aVal.localeCompare(bVal);
                        });
                    }
                    
                    // Reappend sorted rows
                    const tbody = table.querySelector('tbody');
                    tbody.innerHTML = '';
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    };
    
    enhanceTables();
    
    // ===== GPS TRACKING SIMULATION =====
    const initGPSTracking = () => {
        const mapElements = document.querySelectorAll('.gps-map');
        mapElements.forEach(mapElement => {
            // This would integrate with Google Maps API in production
            // For now, we'll show a simulated map
            mapElement.innerHTML = `
                <div class="map-placeholder bg-light d-flex align-items-center justify-content-center" 
                     style="height: 300px; border-radius: 8px;">
                    <div class="text-center">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
                        <h5>GPS Tracking Map</h5>
                        <p class="text-muted">Real-time vehicle location tracking</p>
                        <div class="mt-3">
                            <span class="badge bg-primary me-2">Live</span>
                            <span class="badge bg-success">Connected</span>
                        </div>
                    </div>
                </div>
            `;
        });
    };
    
    initGPSTracking();
    
    // ===== REAL-TIME UPDATES =====
    const initRealTimeUpdates = () => {
        // Simulate real-time notifications
        setInterval(() => {
            // In production, this would connect via WebSocket
            // For now, we'll just simulate occasional updates
            if (Math.random() > 0.7) {
                const notifications = [
                    'New rental request received',
                    'Vehicle maintenance completed',
                    'Customer inquiry requires response',
                    'Payment confirmed for booking #' + Math.floor(Math.random() * 1000)
                ];
                
                const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
                
                // Update notification badge
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    const currentCount = parseInt(badge.textContent) || 0;
                    badge.textContent = currentCount + 1;
                    badge.classList.remove('d-none');
                }
                
                // Show toast notification
                if (typeof showToast === 'function') {
                    showToast(randomNotification, 'info');
                }
            }
        }, 30000); // Check every 30 seconds
    };
    
    initRealTimeUpdates();
    
    // ===== EXPORT FUNCTIONALITY =====
    document.querySelectorAll('.export-btn').forEach(button => {
        button.addEventListener('click', function() {
            const format = this.dataset.format || 'csv';
            const tableId = this.dataset.table;
            
            if (tableId) {
                const table = document.getElementById(tableId);
                if (table) {
                    // Simple CSV export
                    let csv = [];
                    const rows = table.querySelectorAll('tr');
                    
                    rows.forEach(row => {
                        const rowData = [];
                        const cols = row.querySelectorAll('td, th');
                        
                        cols.forEach(col => {
                            rowData.push('"' + col.textContent.replace(/"/g, '""') + '"');
                        });
                        
                        csv.push(rowData.join(','));
                    });
                    
                    const csvContent = csv.join('\n');
                    const blob = new Blob([csvContent], { type: 'text/csv' });
                    const url = URL.createObjectURL(blob);
                    
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'export_' + new Date().toISOString().split('T')[0] + '.csv';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                    
                    showToast('Data exported successfully!', 'success');
                }
            }
        });
    });
    
    // ===== BULK ACTIONS =====
    const initBulkActions = () => {
        const selectAll = document.querySelector('.select-all');
        const checkboxes = document.querySelectorAll('.row-select');
        const bulkAction = document.querySelector('.bulk-action');
        
        if (selectAll && checkboxes.length > 0) {
            selectAll.addEventListener('change', function() {
                const isChecked = this.checked;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkAction();
            });
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkAction);
            });
            
            function updateBulkAction() {
                const checkedCount = document.querySelectorAll('.row-select:checked').length;
                if (checkedCount > 0) {
                    bulkAction.classList.remove('d-none');
                    bulkAction.querySelector('.selected-count').textContent = checkedCount;
                } else {
                    bulkAction.classList.add('d-none');
                }
            }
        }
    };
    
    initBulkActions();
    
    // ===== MODAL ENHANCEMENTS =====
    const enhanceModals = () => {
        // Auto-focus first input in modal
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const input = this.querySelector('input:not([type=hidden]), textarea, select');
                if (input) {
                    setTimeout(() => input.focus(), 100);
                }
            });
        });
    };
    
    enhanceModals();
    
    // ===== FORM WIZARD =====
    const initFormWizards = () => {
        const wizards = document.querySelectorAll('.form-wizard');
        wizards.forEach(wizard => {
            const steps = wizard.querySelectorAll('.wizard-step');
            const nextButtons = wizard.querySelectorAll('.next-step');
            const prevButtons = wizard.querySelectorAll('.prev-step');
            const progress = wizard.querySelector('.wizard-progress');
            
            let currentStep = 0;
            
            const updateWizard = () => {
                // Hide all steps
                steps.forEach(step => step.classList.remove('active'));
                
                // Show current step
                steps[currentStep].classList.add('active');
                
                // Update progress bar
                if (progress) {
                    const percentage = ((currentStep + 1) / steps.length) * 100;
                    progress.style.width = percentage + '%';
                }
                
                // Update buttons
                const isFirstStep = currentStep === 0;
                const isLastStep = currentStep === steps.length - 1;
                
                wizard.querySelectorAll('.prev-step').forEach(btn => {
                    btn.disabled = isFirstStep;
                });
                
                wizard.querySelectorAll('.next-step').forEach(btn => {
                    btn.textContent = isLastStep ? 'Submit' : 'Next';
                });
            };
            
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        updateWizard();
                    }
                });
            });
            
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentStep > 0) {
                        currentStep--;
                        updateWizard();
                    }
                });
            });
            
            updateWizard();
        });
    };
    
    initFormWizards();
    
    // ===== AUTO-SAVE FORMS =====
    const initAutoSave = () => {
        const autoSaveForms = document.querySelectorAll('[data-autosave]');
        autoSaveForms.forEach(form => {
            let saveTimeout;
            
            form.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    // Simulate auto-save
                    const saveIndicator = form.querySelector('.save-indicator');
                    if (saveIndicator) {
                        saveIndicator.classList.remove('d-none');
                        saveIndicator.textContent = 'Saving...';
                        
                        setTimeout(() => {
                            saveIndicator.textContent = 'Saved';
                            setTimeout(() => {
                                saveIndicator.classList.add('d-none');
                            }, 2000);
                        }, 500);
                    }
                }, 1000);
            });
        });
    };
    
    initAutoSave();
    
    console.log('Admin JavaScript loaded successfully!');
});