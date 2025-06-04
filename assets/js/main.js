(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        initMobileMenu();
        initBuyButtons();
        initLanguageSwitcher();
        initProductFilters();
        handleNotifications();
    });

    // Mobile Menu
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const mainNavigation = $('.main-navigation');
        
        menuToggle.on('click', function() {
            $(this).toggleClass('active');
            mainNavigation.toggleClass('active');
        });

        // Close menu when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.main-navigation, .menu-toggle').length) {
                menuToggle.removeClass('active');
                mainNavigation.removeClass('active');
            }
        });
    }

    // Buy Button Functionality
    function initBuyButtons() {
        $('.buy-button').on('click', function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            const productTitle = $(this).closest('.product-card').find('.product-title').text();
            const productPrice = $(this).closest('.product-card').find('.product-price').text();

            // Create modal HTML
            const modalHtml = `
                <div class="purchase-modal">
                    <div class="modal-content">
                        <span class="close-modal">&times;</span>
                        <h3>${productTitle}</h3>
                        <div class="product-details">
                            <p class="price">${productPrice}</p>
                            <div class="quantity-selector">
                <label>Số lượng:</label>
                                <input type="number" min="1" value="1" class="quantity-input">
                            </div>
                        </div>
                        <div class="total-section">
                            <span class="total-label">Tổng tiền:</span>
                            <span class="total-amount">${productPrice}</span>
                        </div>
                        <button class="confirm-purchase">Xác nhận mua</button>
                    </div>
                </div>
            `;

            // Append modal to body
            $('body').append(modalHtml);

            // Show modal
            $('.purchase-modal').fadeIn(300);

            // Handle quantity change
            $('.quantity-input').on('change', function() {
                const quantity = $(this).val();
                const basePrice = parseFloat(productPrice.replace(/[^0-9]/g, ''));
                const total = quantity * basePrice;
                $('.total-amount').text(formatPrice(total) + 'đ');
            });

            // Handle modal close
            $('.close-modal, .purchase-modal').on('click', function(e) {
                if (e.target === this) {
                    $('.purchase-modal').fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });

            // Handle purchase confirmation
            $('.confirm-purchase').on('click', function() {
                const quantity = $('.quantity-input').val();
                
                // Show success notification
                showNotification('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.');
                $('.purchase-modal').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        });
    }

    // Language Switcher
    function initLanguageSwitcher() {
        $('.language-item').on('click', function(e) {
            e.preventDefault();
            
            const lang = $(this).data('lang');
            const currentUrl = window.location.href;

            // Show notification for demo
            showNotification('info', 'Chức năng đang được phát triển');
        });
    }

    // Product Filters
    function initProductFilters() {
        // Category filter
        $('.category-filter a').on('click', function(e) {
            e.preventDefault();
            
            const category = $(this).data('category');
            
            // Update active state
            $('.category-filter a').removeClass('active');
            $(this).addClass('active');

            // Show notification for demo
            showNotification('info', 'Chức năng lọc sản phẩm đang được phát triển');
        });
    }

    // Notifications
    function handleNotifications() {
        // Auto-hide notifications after 5 seconds
        setTimeout(function() {
            $('.notification').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);

        // Allow manual close
        $(document).on('click', '.notification .close', function() {
            $(this).closest('.notification').fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // Helper Functions
    function showNotification(type, message) {
        const notification = `
            <div class="notification ${type}">
                <span class="message">${message}</span>
                <span class="close">&times;</span>
            </div>
        `;

        $('body').append(notification);
        handleNotifications();
    }

    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Handle window resize
    $(window).on('resize', function() {
        // Add responsive handling if needed
    });

    // Handle scroll events
    $(window).on('scroll', function() {
        // Back to top button visibility
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });

    // Back to top functionality
    $('.back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 800);
    });

})(jQuery);
