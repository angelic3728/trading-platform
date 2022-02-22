<template>
    <div class="widget">
        <div class="container h-100">
            <div class="widget-content h-100" ref="widget">
                <div class="widget-animation" :class="animating ? 'animation-running' : 'animation-paused'" :style="{'animation-duration': duration}" @mouseenter="animating = false" @mouseleave="animating = true">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                animating: true,
                duration: 0,
            };
        },

        methods: {

            prefix(key, value) {

                return ['-webkit-', '-moz-', '-ms-', ''].map(el => `${el + key}:${value};`).join('');

            },

            setDuration() {

                this.duration = (Math.max(this.$refs.widget.firstChild.offsetWidth, this.$refs.widget.offsetWidth) / 100) + 's';

            },

            setAnimationStyle() {

                /**
                 * Prepare new style element
                 */
                let element = document.createElement('style');

                /**
                 * Prepare from and to
                 */
                let from = this.prefix('transform', `translateX(0px)`);
                let to = this.prefix('transform', `translateX(-${(this.$refs.widget.firstChild.offsetWidth - this.$refs.widget.offsetWidth)}px)`);

                /**
                 * Prepare animation
                 */
                let animation = `@keyframes widget-animation {
                          0% { ${from} }
                          100% { ${to} }
                      }`;

                /**
                 * Set Animation Style
                 */
                element.innerHTML = animation;
                document.head.appendChild(element);

            },

        },

        mounted() {

            this.$nextTick(() => {
                this.setDuration();
                this.setAnimationStyle();
            });

        },

    }
</script>
