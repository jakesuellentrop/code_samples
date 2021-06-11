<template>
    <div>
        <div class="min-h-screen bg-primary-100">
            <nav class="bg-white border-b border-primary-200 h-20 p-2 w-full z-50 lg:h-40">
                <!-- Primary Navigation Menu -->
                <div class="flex h-full items-center justify-between max-w-10xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex h-full items-center">
                            <inertia-link class="h-4/5" :href="route('dashboard')">
                                <jet-application-mark class="block w-1/2 lg:w-auto" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 lg:flex">
                            <component :is="navigationType" />
                        </div>
                    </div>

                    <my-account-button :auth="true" :csrf="$page.props.csrf" />
                </div>

                <div v-if="$page.props.user" class="bg-primary-900 border-t border-primary-200 border-solid bottom-0 fixed flex h-20 items-center justify-between left-0 shadow text-white w-full lg:hidden">
                    <component :is="mobileNavigationType" />
                </div>

                <!-- Responsive Navigation Menu -->
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex">
                <div class="max-w-6xl mx-auto pb-20 pt-16 x-6 w-full lg:px-8">
                    <slot></slot>
                </div>

                <div v-if="showCart" class="border-l border-primary-300 pb-16 pt-16 px-8 w-80">
                    <h2 class="font-light mb-8 text-center text-h2 uppercase">Your Order</h2>

                    <fmm-svg v-if="cartIsEmpty" icon="empty-cart" class="mx-auto" />

                    <div v-for="item in cartItems" :key="item.id" class="border-b border-primary-300 py-4 text-primary-800">
                        <div class="flex font-bold justify-between text-link">
                            <p>{{ item.name }}</p>
                            <p>${{ parseFloat(item.price * item.quantity).toFixed(2) }}</p>
                        </div>
                        <p class="mt-1 text-xs">{{ item.attributes.vendor.name }}</p>
                        <p class="mt-2 text-link">x{{ item.quantity }}</p>
                        <button type="button" class="italic mt-2" @click="removeCartItem(item)">Remove</button>
                    </div>

                    <template v-if="! cartIsEmpty">
                        <div class="flex font-bold justify-between mt-8 text-body text-primary-800 uppercase">
                            <p>Subtotal</p>
                            <p>${{ parseFloat(cart.subtotal).toFixed(2) }}</p>
                        </div>
                        <inertia-link :href="route('orders.review')">
                            <jet-button type="button" class="justify-center mt-8 px-8 py-2 text-body w-full">Check Out</jet-button>
                        </inertia-link>
                        <!-- <jet-secondary-button type="button" class="mt-4">Add More Products</jet-secondary-button> -->
                    </template>
                </div>
            </main>

            <footer class="bg-primary-900 flex font-bold h-20 items-center justify-center text-sm text-white uppercase">
                <p>&copy; {{ (new Date()).getFullYear() }} First Mile Market</p>
                <span class="mx-3">|</span>
                <p>Privacy Policy</p>
                <span class="mx-3">|</span>
                <p>Contact Us</p>
            </footer>
        </div>
    </div>
</template>

<script>
    import Cart from '@/Mixins/Cart'
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import MyAccountButton from '@/Navigation/MyAccountButton'
    import { computed, watch } from '@vue/runtime-core'
    import { usePage } from '@inertiajs/inertia-vue3'
    import { useToast } from 'vue-toastification'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            MyAccountButton
        },

        mixins: [
            Cart
        ],

        props: {
            showCart: {
                default: false
            }
        },

        setup (props, context) {
            const flash = computed(() => usePage().props.value.flash)
            const toast = useToast()

            watch(flash, (newMessage, oldMessage) => {
                Object.entries(newMessage).forEach((message) => {
                    if (! message[1]) return

                    toast[message[0]](message[1])
                })
            })
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        computed: {
            currentTeam() {
                if (! this.$page.props.user) {
                    return 'guest'
                }

                return this.$page.props.user.current_team.type
            },

            navigationType() {
                return `${this.currentTeam}-navigation`
            },

            mobileNavigationType() {
                return `${this.navigationType}-mobile`
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
