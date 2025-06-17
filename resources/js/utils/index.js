export const Utils = {
    // Store event handler references for proper cleanup
    dateChangeHandlers: {
        startDate: null,
        endDate: null,
    },

    // Add method to initialize date pickers
    initDateRangeFilter() {
        const dateRangeStartPicker = document.getElementById(
            "datepicker-range-start"
        );
        const dateRangeEndPicker = document.getElementById(
            "datepicker-range-end"
        );

        if (dateRangeStartPicker && dateRangeEndPicker) {
            // Remove existing event listeners if they exist
            if (this.dateChangeHandlers.startDate) {
                dateRangeStartPicker.removeEventListener(
                    "changeDate",
                    this.dateChangeHandlers.startDate
                );
            }
            if (this.dateChangeHandlers.endDate) {
                dateRangeEndPicker.removeEventListener(
                    "changeDate",
                    this.dateChangeHandlers.endDate
                );
            }

            // Store reference to current DataTable for reloading
            let currentTable = null;
            try {
                if ($.fn.DataTable.isDataTable("#data-table")) {
                    currentTable = $("#data-table").DataTable();
                }
            } catch (e) {
                console.log("DataTable reference error:", e);
            }

            // Create new event handlers
            this.dateChangeHandlers.startDate = (e) => {
                this.selectedStartDate = e.detail.date;
                this.reloadDataTable(currentTable);
            };

            this.dateChangeHandlers.endDate = (e) => {
                this.selectedEndDate = e.detail.date;
                this.reloadDataTable(currentTable);
            };

            // Add fresh event listeners
            dateRangeStartPicker.addEventListener(
                "changeDate",
                this.dateChangeHandlers.startDate
            );
            dateRangeEndPicker.addEventListener(
                "changeDate",
                this.dateChangeHandlers.endDate
            );
        }
    },

    // Separate method for reloading DataTable
    reloadDataTable(table) {
        if (!table) return;

        table.ajax.params = (d) => {
            // Reset all custom parameters
            delete d.start_date;
            delete d.end_date;

            // Add new parameters if dates are selected
            if (this.selectedStartDate) {
                d.start_date = this.selectedStartDate;
            }
            if (this.selectedEndDate) {
                d.end_date = this.selectedEndDate;
            }
            return d;
        };

        table.ajax.reload();
    },

    initDataTable(pageType) {
        const tableElement = document.getElementById("data-table");
        if (!tableElement || !PAGE_CONFIGS[pageType]) return;

        // Destroy existing DataTable
        if ($.fn.DataTable.isDataTable("#data-table")) {
            $("#data-table").DataTable().destroy();
        }

        const config = PAGE_CONFIGS[pageType];
        config.columns.forEach((col) => {
            if (col.title && col.title.toLowerCase() === "action") {
                col.orderable = false;
            }
        });
        const dataTableConfig = {
            ...DATATABLE_CONFIG,
            ajax: {
                url: config.url,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: (d) => {
                    // Add date range parameters to DataTable request
                    const dateRangeStartPicker = document.getElementById(
                        "datepicker-range-start"
                    );
                    const dateRangeEndPicker = document.getElementById(
                        "datepicker-range-end"
                    );

                    if (dateRangeStartPicker && dateRangeStartPicker.value) {
                        d.start_date = dateRangeStartPicker.value;
                    }
                    if (dateRangeEndPicker && dateRangeEndPicker.value) {
                        d.end_date = dateRangeEndPicker.value;
                    }
                    return d;
                },
            },
            columns: config.columns,
        };

        $("#data-table").DataTable(dataTableConfig);

        // Initialize date pickers after DataTable is created
        this.initDateRangeFilter();
    },

    getPageType(url) {
        const pathname = new URL(url, window.location.origin).pathname;
        return PAGE_CONFIGS[pathname] ? pathname : null;
    },

    isHashOnlyChange(newUrl, currentUrl = window.location.href) {
        const newUrlObj = new URL(newUrl);
        const currentUrlObj = new URL(currentUrl);

        newUrlObj.hash = "";
        currentUrlObj.hash = "";

        return newUrlObj.href === currentUrlObj.href;
    },

    handleHashNavigation(url) {
        const hash = new URL(url).hash;
        if (hash) {
            const targetElement = document.querySelector(hash);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                });
            }
        }
        history.pushState({}, "", url);
    },

    scrollToHash(hash, delay = 100) {
        if (!hash) return;

        setTimeout(() => {
            const targetElement = document.querySelector(hash);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                });
            }
        }, delay);
    },

    // Enhanced page content loading with proper cleanup
    async loadPageContent(url) {
        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const html = await response.text();

            // Clean up any existing components before loading new content
            this.cleanupComponents();

            const container = document.getElementById("main-content");

            container.innerHTML = html;

            // Initialize components for the new page
            const pageType = this.getPageType(url);
            if (pageType) {
                // Add a small delay to ensure DO
                this.initDataTable(pageType); // Increased delay for better reliability
            } else {
                // Still initialize date pi
                this.initDateRangeFilter();
            }

            const hash = new URL(url).hash;
            this.scrollToHash(hash);
            return true;
        } catch (error) {
            console.error("Failed to load page content:", error);
            return false;
        }
    },

    // Improved cleanup method
    cleanupComponents() {
        // Destroy existing DataTable
        if ($.fn.DataTable.isDataTable("#data-table")) {
            $("#data-table").DataTable().destroy();
        }

        // Clear date picker references
        this.selectedStartDate = null;
        this.selectedEndDate = null;

        // Clean up datepicker components
        const datePickerElements = document.querySelectorAll(
            "#datepicker-range-start, #datepicker-range-end"
        );

        datePickerElements.forEach((element, index) => {
            // Remove existing event listeners using stored references
            if (index === 0 && this.dateChangeHandlers.startDate) {
                element.removeEventListener(
                    "changeDate",
                    this.dateChangeHandlers.startDate
                );
            }
            if (index === 1 && this.dateChangeHandlers.endDate) {
                element.removeEventListener(
                    "changeDate",
                    this.dateChangeHandlers.endDate
                );
            }

            // Destroy Flowbite datepicker instance
            if (
                element._datepicker &&
                typeof element._datepicker.destroy === "function"
            ) {
                element._datepicker.destroy();
            }

            // Clear the input value
            element.value = "";
        });

        // Clear stored event handlers
        this.dateChangeHandlers.startDate = null;
        this.dateChangeHandlers.endDate = null;
    },

    cleanCreateFormHandler() {
        const form = document.getElementById("form-create");
        if (form) {
            // Remove existing event listeners by cloning
            const newForm = form.cloneNode(true);
            form.parentNode.replaceChild(newForm, form);

            // Reset form input
            newForm.reset();

            // Remove error messages
            newForm
                .querySelectorAll(".error-message")
                .forEach((el) => el.remove());

            // Remove red border classes
            newForm
                .querySelectorAll(".border-red-500")
                .forEach((el) => el.classList.remove("border-red-500"));

            // Reset submit button
            const submitBtn = newForm.querySelector("#btn-submit");
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = "Submit";
                submitBtn.type = "submit";
            }
        }
    },

    async initFormCreateHandler() {
        // Clean existing handlers first
        this.cleanCreateFormHandler();

        const submitBtn = document.getElementById("btn-submit");

        if (submitBtn) {
            submitBtn.addEventListener("click", async (e) => {
                e.preventDefault();

                const form = document.getElementById("form-create");
                console.log(form);
                if (!form) return;

                // Prevent double submission
                if (submitBtn.disabled) {
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                    </svg>
                                    Loading...
                                `;

                try {
                    const response = await EventHandlers.makeAjaxRequest(
                        form.action,
                        "POST",
                        form
                    );

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = "Submit";
                    if (typeof response === "object" && response.redirect) {
                        window.location.href = response.redirect;
                    } else if (
                        typeof response === "object" &&
                        response.message
                    ) {
                        alert(response.message);
                        form.reset();
                    } else if (typeof response === "string") {
                        console.log("HTML response received");
                    }
                } catch (error) {
                    console.error("Error:", error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = "Submit";
                    alert("An error occurred: " + error.message);
                }
            });

            this.initCreateDatePicker();
        }
    },

    initCreateDatePicker() {
        const tanggalPicker = document.getElementById("tanggal");

        if (tanggalPicker) {
            setTimeout(() => {
                try {
                    if (typeof window.initDatePicker === "function") {
                        window.initDatePicker("#tanggal");
                    } else if (typeof window.initFlowbite === "function") {
                        window.initFlowbite();
                    }
                } catch (e) {
                    console.log("Init error for Tanggal Hutang datepicker:", e);
                }

                // Initialize date change handlers
                if (!this.dateChangeHandlers) {
                    this.dateChangeHandlers = {};
                }

                this.dateChangeHandlers.tanggal = (e) => {
                    this.selectedtanggal = e.detail.date;
                };

                tanggalPicker.addEventListener(
                    "changeDate",
                    this.dateChangeHandlers.tanggal
                );
            }, 100);
        }
    },

    initFormEditHandler() {
        const waitForForm = () => {
            const form = document.getElementById("form-edit");
            if (form) {
                // Set form attributes
                form.method = "POST";

                const submitBtn = form.querySelector("#btn-submit");

                form.addEventListener("submit", async (e) => {
                    e.preventDefault();

                    if (submitBtn.disabled) return;

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                        </svg>
                                        Loading...
                                    `;

                    try {
                        const response = await fetch(form.action, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content,
                                Accept: "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                            },
                            body: new FormData(form),
                        });

                        const result = await response.json();

                        submitBtn.disabled = false;
                        submitBtn.innerHTML = "Update";
                        if (result.redirect) {
                            window.location.href = result.redirect;
                        } else if (result.message) {
                            alert(result.message);
                        }
                    } catch (error) {
                        console.error("Error:", error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = "Update";
                        alert("An error occurred: " + error.message);
                    }
                });
            } else {
                // Retry after a short delay if form not found
                setTimeout(waitForForm, 100);
            }
        };

        waitForForm();
    },

    initSalesChart() {
        fetch("/api/sales-last-7-days")
            .then((response) => response.json())
            .then((data) => {
                const dates = data.map((item) => item.date);
                const totals = data.map((item) => item.total);

                const options = {
                    chart: {
                        height: "100%",
                        width: "100%",
                        type: "area",
                        fontFamily: "Inter, sans-serif",
                        toolbar: { show: false },
                        dropShadow: { enabled: false },
                    },
                    tooltip: {
                        enabled: true,
                        x: { show: true },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            opacityFrom: 0.55,
                            opacityTo: 0,
                            shade: "#1C64F2",
                            gradientToColors: ["#1C64F2"],
                        },
                    },
                    dataLabels: { enabled: false },
                    stroke: { width: 6 },
                    grid: {
                        show: false,
                        strokeDashArray: 4,
                        padding: { left: 2, right: 2, top: 0 },
                    },
                    series: [
                        {
                            name: "Sales",
                            data: totals,
                            color: "#1A56DB",
                        },
                    ],
                    xaxis: {
                        categories: dates,
                        labels: { show: true },
                        axisBorder: { show: false },
                        axisTicks: { show: true },
                    },
                    yaxis: { show: true },
                };

                const el = document.getElementById("area-chart");
                if (el && typeof ApexCharts !== "undefined") {
                    const chart = new ApexCharts(el, options);
                    chart.render();
                }
            })
            .catch((error) => {
                console.error("Error fetching sales chart data:", error);
            });
    },

    initBestSellerChart() {
        fetch("/api/best-seller-products")
            .then((response) => response.json())
            .then((data) => {
                const products = data.products || [];

                if (products.length === 0) {
                    document
                        .getElementById("no-product-info")
                        .classList.remove("hidden");
                    return;
                }

                const categories = products.map((p) => p.name);
                const quantities = products.map((p) => p.qty);

                const options = {
                    series: [
                        {
                            name: "Jumlah Terjual",
                            data: quantities,
                        },
                    ],
                    chart: {
                        type: "bar",
                        height: 400,
                        toolbar: { show: false },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: "60%",
                            distributed: true,
                        },
                    },
                    dataLabels: { enabled: false },
                    colors: [
                        "#3B82F6",
                        "#10B981",
                        "#F59E0B",
                        "#EF4444",
                        "#8B5CF6",
                        "#EC4899",
                    ],
                    xaxis: {
                        categories: categories,
                        labels: {
                            style: {
                                fontFamily: "Inter, sans-serif",
                                fontSize: "14px",
                                colors: "#6B7280",
                            },
                        },
                        title: {
                            text: "Jumlah Terjual",
                            style: {
                                fontWeight: 600,
                                fontSize: "14px",
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontFamily: "Inter, sans-serif",
                                fontSize: "14px",
                                fontWeight: 500,
                                colors: "#374151",
                            },
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: (val) => `${val} unit`,
                        },
                    },
                    grid: {
                        borderColor: "#E5E7EB",
                        strokeDashArray: 4,
                    },
                };

                const el = document.querySelector("#bar-chart");
                if (el && typeof ApexCharts !== "undefined") {
                    const chart = new ApexCharts(el, options);
                    chart.render();
                }
            })
            .catch((error) => {
                console.error("Gagal mengambil data produk terlaris:", error);
                document
                    .getElementById("no-product-info")
                    .classList.remove("hidden");
            });
    },
};
