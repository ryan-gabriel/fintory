import "./bootstrap";
import { PAGE_CONFIGS } from "./config/pageConfigs";
import { DATATABLE_CONFIG } from "./config/dataTableConfigs";
import { Utils } from "./utils";
import { EventHandlers } from "./handlers/EventHandlers";

import Alpine from "alpinejs";
import "aos/dist/aos.css";
import AOS from "aos";

// Global injection
window.PAGE_CONFIGS = PAGE_CONFIGS;
window.DATATABLE_CONFIG = DATATABLE_CONFIG;
window.Utils = Utils;
window.EventHandlers = EventHandlers;

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    AOS.init({
        duration: 800,
        once: true,
        offset: 50,
    });
  });

document.body.addEventListener('click', EventHandlers.handleLinkClick.bind(EventHandlers));
document.body.addEventListener('submit', EventHandlers.handleFormSubmit.bind(EventHandlers), true);
window.addEventListener('popstate', EventHandlers.handlePopState.bind(EventHandlers));
document.addEventListener('DOMContentLoaded', EventHandlers.handleDOMContentLoaded.bind(EventHandlers));
window.addEventListener('load', EventHandlers.handleWindowLoad.bind(EventHandlers));