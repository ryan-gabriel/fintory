import { Utils } from "../utils";

let previousUrl = window.location.href;

export const EventHandlers = {
    linkConfigs: {
        ".menu-link": {
            method: "GET",
            loadIntoContainer: "#main-content",
            showLoader: true,
            updateHistory: true,
            updateTitle: true,
            onSuccess: (response, element) => {
                // Jika masuk ke /dashboard, lakukan refresh
                const url = element.href || element.getAttribute("data-url");
                if (url) {
                    const pathname = new URL(url, window.location.origin)
                        .pathname;
                    if (pathname == "/dashboard") {
                        Utils.initBestSellerChart();
                        Utils.initSalesChart();
                    }
                }
            },
        },
        ".create-link": {
            method: "GET",
            loadIntoContainer: "#main-content",
            showLoader: true,
            updateHistory: true,
            updateTitle: true,
            onSuccess: (response, element) => {
                const url = element.href || element.getAttribute("data-url");
                Utils.initFormCreateHandler();
                if (url) {
                    const pathname = new URL(url, window.location.origin).pathname;

                    // Cicilan
                    if (
                        pathname === '/dashboard/keuangan/cicilan/create' ||
                        (pathname.startsWith('/dashboard/keuangan/cicilan/') && pathname.endsWith('/edit'))
                    ) {
                        Utils.initCicilanForm();
                    }

                    // Kas Ledger
                    if (
                        pathname === '/dashboard/keuangan/kas-ledger/create' ||
                        (pathname.startsWith('/dashboard/keuangan/kas-ledger/') && pathname.endsWith('/edit'))
                    ) {
                        Utils.initKasLedgerForm();
                    }
                }
            },
        },

        ".edit-link": {
            method: "GET",
            loadIntoContainer: "#main-content",
            showLoader: true,
            updateHistory: true,
            updateTitle: true,
            onSuccess: (response, element) => {
                const url = element.href || element.getAttribute("data-url");
                Utils.initFormEditHandler();
                if (url) {
                    const pathname = new URL(url, window.location.origin).pathname;

                    // Cicilan
                    if (
                        pathname === '/dashboard/keuangan/cicilan/create' ||
                        (pathname.startsWith('/dashboard/keuangan/cicilan/') && pathname.endsWith('/edit'))
                    ) {
                        Utils.initCicilanForm();
                    }

                    // Kas Ledger
                    if (
                        pathname === '/dashboard/keuangan/kas-ledger/create' ||
                        (pathname.startsWith('/dashboard/keuangan/kas-ledger/') && pathname.endsWith('/edit'))
                    ) {
                        Utils.initKasLedgerForm();
                    }
                }
            },
        },
        ".ajax-link": {
            method: "GET",
            loadIntoContainer: "#main-content",
            showLoader: true,
            updateHistory: false,
            updateTitle: false,
        },
        ".modal-link": {
            method: "GET",
            loadIntoContainer: "#modal-content",
            showLoader: false,
            updateHistory: false,
            updateTitle: false,
            afterLoad: (response, element) => {
                const modal = document.getElementById("modal");
                if (modal) {
                    modal.classList.remove("hidden");
                }
            },
        },
    },

    // Method untuk menentukan konfigurasi link
    getLinkConfig(element) {
        for (const [selector, config] of Object.entries(this.linkConfigs)) {
            if (element.matches(selector) || element.closest(selector)) {
                return {
                    selector,
                    ...config,
                };
            }
        }
        return null;
    },

    // Enhanced handle click untuk semua jenis link
    async handleLinkClick(e) {
        const clickedElement = e.target;
        // Cari elemen yang cocok dengan konfigurasi di linkConfigs
        const linkElement = Object.keys(this.linkConfigs).reduce(
            (acc, selector) => acc || clickedElement.closest(selector),
            null
        );

        if (!linkElement) return;

        const config = this.getLinkConfig(linkElement);
        if (!config) return;

        e.preventDefault();
        e.stopPropagation();

        const url = linkElement.href || linkElement.getAttribute("data-url");
        previousUrl = url;
        if (!url) return;

        // Handle konfirmasi (sekarang dengan SweetAlert) jika diperlukan
        if (config.requireConfirmation) {
            try {
                const result = await Swal.fire({
                    title: config.confirmMessage || "Anda yakin?",
                    text: "Tindakan ini tidak dapat dibatalkan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Lanjutkan!",
                    cancelButtonText: "Batal",
                });
                if (!result.isConfirmed) {
                    return; // Berhenti jika pengguna menekan "Batal"
                }
            } catch (error) {
                console.error("SweetAlert error:", error);
                return; // Berhenti jika ada error
            }
        }

        try {
            if (config.showLoader) this.showLoader();
            const response = await this.makeAjaxRequest(
                url,
                config.method,
                linkElement
            );

            if (config.method === "GET" && config.loadIntoContainer) {
                await this.loadContentIntoContainer(
                    response,
                    config.loadIntoContainer,
                    url
                );
            }
            if (config.updateHistory) {
                history.pushState({}, "", url);
            }
            if (config.updateTitle) {
                document.title =
                    linkElement.getAttribute("data-title") || document.title;
            }
            if (config.onSuccess) await config.onSuccess(response, linkElement);
            if (config.afterLoad) await config.afterLoad(response, linkElement);
        } catch (error) {
            console.error("Request failed:", error);
            if (config.onError) {
                await config.onError(error, linkElement);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        } finally {
            if (config.showLoader) this.hideLoader();
        }
    }, // Method untuk melakukan AJAX request
    async makeAjaxRequest(url, method = "GET", element = null) {
        const options = {
            method: method,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        };

        // Hanya proses FormData jika element ada di dalam sebuah form
        // Ini akan memperbaiki tombol Hapus yang tidak berada di dalam form
        const form = element ? element.closest("form") : null;
        if (form && ["POST", "PUT", "PATCH"].includes(method)) {
            options.body = new FormData(form);
        }

        const response = await fetch(url, options);

        if (!response.ok) {
            const error = new Error(
                `HTTP ${response.status}: ${response.statusText}`
            );
            error.response = response; // Lampirkan response ke error untuk penanganan lebih baik
            throw error;
        }

        // Return response berdasarkan content type
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return await response.json();
        } else if (response.redirected && response.url) {
            window.location.href = response.url;
            return;
        } else {
            return await response.text();
        }
    },

    // Method untuk load content ke container
    async loadContentIntoContainer(content, containerSelector, url) {
        const container = document.querySelector(containerSelector);
        if (!container) {
            throw new Error(`Container ${containerSelector} not found`);
        }

        // Clean up existing components
        Utils.cleanupComponents();

        // Load new content
        if (typeof content === "string") {
            container.innerHTML = content;
        } else {
            // Handle JSON response
            if (content.html) {
                container.innerHTML = content.html;
            }
        }

        // Initialize components untuk halaman baru
        const pageType = Utils.getPageType(url);
        if (pageType) {
            Utils.initDataTable(pageType);
        } else {
            Utils.initDateRangeFilter();
        }

        // Handle hash navigation
        const hash = new URL(url, window.location.origin).hash;
        if (hash) {
            Utils.scrollToHash(hash);
        }

        // Reinitialize Flowbite components
        if (typeof window.initFlowbite === "function") {
            window.initFlowbite();
        }
    },

    // Method untuk show/hide loader
    showLoader() {
        const loader = document.getElementById("loader");
        const mainContent = document.getElementById("main-content");

        if (loader) loader.classList.remove("hidden");
        if (mainContent) mainContent.classList.add("hidden");
    },

    hideLoader() {
        const loader = document.getElementById("loader");
        const mainContent = document.getElementById("main-content");

        if (loader) loader.classList.add("hidden");
        if (mainContent) mainContent.classList.remove("hidden");
    },

    // Handle form submission via AJAX
    async handleFormSubmit(e) {
        const form = e.target;

        // Cek apakah form memiliki class ajax-form
        if (!form.classList.contains("ajax-form")) return;

        e.preventDefault();

        const url = form.action;
        const method = form.method.toUpperCase();
        const formData = new FormData(form);

        try {
            this.showLoader();

            const response = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const result = await response.json();

            // Handle success response
            if (result.success) {
                // Redirect jika ada redirect URL
                if (result.redirect) {
                    await this.loadContentIntoContainer(
                        await this.makeAjaxRequest(result.redirect),
                        "#main-content",
                        result.redirect
                    );
                    history.pushState({}, "", result.redirect);
                }

                // Reload DataTable jika ada
                if ($.fn.DataTable.isDataTable("#data-table")) {
                    $("#data-table").DataTable().ajax.reload();
                }

                // Show success message
                if (result.message) {
                    Swal.fire({
                        icon: 'success',
                        title: result.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            } else {
                // Handle validation errors
                this.handleFormErrors(form, result.errors || {});
            }
        } catch (error) {
            console.error("Form submission failed:", error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan. Silakan coba lagi.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } finally {
            this.hideLoader();
        }
    },

    // Handle form validation errors
    handleFormErrors(form, errors) {
        // Clear previous errors
        form.querySelectorAll(".error-message").forEach((el) => el.remove());
        form.querySelectorAll(".border-red-500").forEach((el) => {
            el.classList.remove("border-red-500");
        });

        // Display new errors
        Object.keys(errors).forEach((fieldName) => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.add("border-red-500");

                const errorDiv = document.createElement("div");
                errorDiv.className = "error-message text-red-500 text-sm mt-1";
                errorDiv.textContent = errors[fieldName][0];

                field.parentNode.appendChild(errorDiv);
            }
        });
    },

    // Handle browser back/forward navigation
    handlePopState(event) {
        const currentUrl = window.location.href;
        if (Utils.isHashOnlyChange(currentUrl, previousUrl)) {
            const hash = new URL(currentUrl).hash;
            Utils.scrollToHash(hash);
            previousUrl = currentUrl;
            return;
        }

        this.showLoader();

        this.makeAjaxRequest(currentUrl)
            .then((content) => {
                this.loadContentIntoContainer(
                    content,
                    "#main-content",
                    currentUrl
                );
            })
            .catch((error) => {
                console.error("Failed to load page:", error);
                window.location.reload();
            })
            .finally(() => {
                this.hideLoader();
                previousUrl = currentUrl;
            });
    },

    // Handle initial page load
    handleDOMContentLoaded() {
        const pageType = Utils.getPageType(location.href);
        if (pageType) {
            Utils.initDataTable(pageType);
        } else {
            Utils.initDateRangeFilter();
        }

        Utils.scrollToHash(window.location.hash);
    },

    // Handle window load
    handleWindowLoad() {
        this.hideLoader();
    },
};
