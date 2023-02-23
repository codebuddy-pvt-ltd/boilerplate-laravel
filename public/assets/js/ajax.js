// load /public/assets/shared/js/toast.js before this file
/* eslint-disable-next-line */
class Ajax {
    constructor(url, type = "POST", data = {}, hasFormData = false) {
        this.url = url;
        this.type = type;
        this.data = data;
        this.hasFormData = hasFormData;
        this.id = Ajax.generateId();
        this.events = {
            beforeSend: `ajax.pre.${this.id}`,
            onError: `ajax.error.${this.id}`,
            onSuccess: `ajax.success.${this.id}`,
            onComplete: `ajax.complete.${this.id}`,
        };
    }

    static generateId() {
        return Date.now() + Math.floor(Math.random() * 100);
    }

    static addEventListener(eventName, callback) {
        window.addEventListener(eventName, callback, { once: true });
    }

    beforeSend(callback) {
        Ajax.addEventListener(this.events.beforeSend, callback);
        return this;
    }

    onError(callback) {
        Ajax.addEventListener(this.events.onError, callback);
        return this;
    }

    onSuccess(callback) {
        Ajax.addEventListener(this.events.onSuccess, callback);
        return this;
    }

    onComplete(callback) {
        Ajax.addEventListener(this.events.onComplete, callback);
        return this;
    }

    send() {
        const ajaxConfig = {
            type: this.type,
            url: this.url,
            data: this.data,
            mimeType: "multipart/form-data",
            beforeSend: () => {
                window.dispatchEvent(new CustomEvent(this.events.beforeSend));
            },
            error: (response) => {
                let res;

                try {
                    res = JSON.parse(response.responseText);
                } catch (err) {
                    /* eslint-disable-next-line */
                    showToast("error", "Error! Try again!");
                    return;
                }

                const {
                    status,
                    message,
                    notificationDisplayTime,
                    dispatchEvents,
                } = res;

                if (status && message) {
                    /* eslint-disable-next-line */
                    showToast(status, message, notificationDisplayTime);
                }

                if (dispatchEvents) {
                    dispatchEvents.forEach((value) => {
                        const { eventName, data } = value;
                        window.dispatchEvent(
                            new CustomEvent(eventName, {
                                detail: { data },
                            })
                        );
                    });
                }

                window.dispatchEvent(
                    new CustomEvent(this.events.onError, {
                        detail: { res },
                    })
                );
            },
            success: (response) => {
                const res = JSON.parse(response);

                const {
                    status,
                    message,
                    notificationDisplayTime,
                    redirectTo,
                    hideModal,
                    showModal,
                    hideSidebar,
                    showSidebar,
                    hideSection,
                    showSection,
                    refresh,
                    html,
                    refreshDataTable,
                    dispatchEvents,
                } = res;

                if (status && message) {
                    /* eslint-disable-next-line */
                    showToast(status, message, notificationDisplayTime);
                }

                if (redirectTo && notificationDisplayTime) {
                    setTimeout(() => {
                        window.location.replace(redirectTo);
                    }, notificationDisplayTime);
                } else if (redirectTo) {
                    window.location.replace(redirectTo);
                }

                if (hideModal) {
                    $(document).find(hideModal).modal("hide");
                }

                if (showModal) {
                    $(document).find(showModal).modal("show");
                }

                if (hideSidebar) {
                    $(document).find(hideSidebar).removeClass("active");
                }

                if (showSidebar) {
                    $(document).find(showSidebar).addClass("active");
                }

                if (hideSection) {
                    $(document).find(hideSection).hide();
                }

                if (showSection) {
                    $(document).find(showSection).show();
                }

                if (dispatchEvents) {
                    dispatchEvents.forEach((value) => {
                        const { eventName, data } = value;
                        window.dispatchEvent(
                            new CustomEvent(eventName, {
                                detail: { data },
                            })
                        );
                    });
                }

                if (refresh && notificationDisplayTime) {
                    setTimeout(() => {
                        window.location.reload();
                    }, notificationDisplayTime);
                } else if (refresh) {
                    window.location.reload();
                    return;
                }

                if (html) {
                    $(html.id).html(html.content);
                }

                if (refreshDataTable) {
                    $(refreshDataTable).DataTable().ajax.reload();
                }

                window.dispatchEvent(
                    new CustomEvent(this.events.onSuccess, {
                        detail: { res },
                    })
                );
            },
            complete: () => {
                window.dispatchEvent(new CustomEvent(this.events.onComplete));
            },
        };

        if (this.hasFormData) {
            Object.assign(ajaxConfig, {
                processData: false,
                contentType: false,
            });
        }

        $.ajax(ajaxConfig);
    }
}
