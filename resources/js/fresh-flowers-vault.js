/**
 * Maja Flower - Daily Fresh Bloom Vault Component (Alpine.js Data Module)
 * Memisahkan logika kalkulasi subtotal, kuota tangkai, dan WA link generator dari template Blade.
 */
export function freshFlowersVault(initialFlowers = [], waNumber = '6285882119900') {
    return {
        filterStatus: 'all',
        searchQuery: '',
        selectedQuantities: {},
        activeCardId: null,
        flowers: initialFlowers,
        waNumber: waNumber,

        init() {
            this.flowers.forEach(f => {
                const defaultQty = f.stock_stems > 0 ? (f.stock_stems >= 5 ? 5 : f.stock_stems) : 1;
                this.selectedQuantities[f.id] = defaultQty;
            });
        },

        getQuantity(id) {
            return this.selectedQuantities[id] || 5;
        },

        setQuantity(id, qty, maxStock) {
            const max = maxStock > 0 ? maxStock : 99;
            this.selectedQuantities[id] = Math.max(1, Math.min(qty, max));
        },

        getSubtotal(flower) {
            const qty = this.getQuantity(flower.id);
            if (!flower.price_raw) return '';
            return 'Rp ' + Number(flower.price_raw * qty).toLocaleString('id-ID');
        },

        getWaLink(flower) {
            const qty = this.getQuantity(flower.id);
            const subtotal = flower.price_raw > 0 ? ' (Estimasi Total: Rp ' + Number(flower.price_raw * qty).toLocaleString('id-ID') + ')' : '';
            const msg = `Halo Florist MAJA FLOWER, saya ingin memesan bunga segar *${flower.name}* (${flower.color_name}) sebanyak *${qty} tangkai*${subtotal}.\n\nApakah stok ready untuk dirangkai hari ini?`;
            return `https://wa.me/${this.waNumber}?text=${encodeURIComponent(msg)}`;
        },

        toggleCard(id) {
            this.activeCardId = (this.activeCardId === id) ? null : id;
        },

        isCardActive(id) {
            return this.activeCardId === id;
        },

        filteredFlowers() {
            return this.flowers.filter(item => {
                const matchStatus = this.filterStatus === 'all' || item.status === this.filterStatus;
                const query = this.searchQuery.toLowerCase().trim();
                const matchSearch = !this.searchQuery ||
                    item.name.toLowerCase().includes(query) ||
                    (item.botanical_name && item.botanical_name.toLowerCase().includes(query)) ||
                    item.color_name.toLowerCase().includes(query) ||
                    (item.origin && item.origin.toLowerCase().includes(query));
                return matchStatus && matchSearch;
            });
        }
    };
}
