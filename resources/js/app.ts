import '../css/app.css';
import Alpine from 'alpinejs'
import ClipboardJS from "clipboard";
import {computePosition, flip, shift, offset} from "@floating-ui/dom";

window.Alpine = Alpine

new ClipboardJS('[data-clipboard-target]');

document.addEventListener('alpine:init', () => {
    Alpine.data('emoji', () => ({
        open: false,
        copied : false,
        hovered: false,
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => {
                    computePosition(this.$refs.button, this.$refs.tooltip, {
                        placement: 'top-start',
                        middleware: [offset(2), flip(), shift()],
                    }).then(({ x, y }) => {
                        Object.assign(this.$refs.tooltip.style, {
                            left: `${x}px`,
                            top: `${y}px`,
                        });
                    });
                });
            }
        },
        copy (id: number) {
            this.copied = true;
            this.hovered = false;
            setTimeout(() => this.copied = false, 2000)
            fetch(`/emojis/${id}/increment`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') as string,
                }
            }).catch(e => console.error(e))
        }
    }));
});

Alpine.start()




