import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;

Alpine.data('appData', (serverLineup, serverTickets, serverSettings, serverTracks) => ({
    // --- STATE UI & GLOBAL ---
    menuOpen: false,
    mousePos: { x: 0, y: 0 },
    timeLeft: { HARI: 0, JAM: 0, MENIT: 0, DETIK: 0 },
    
    // --- CHAT STATE ---
    chatOpen: false,
    inputMsg: '',
    messages: [{ role: 'model', text: 'SISTEM ONLINE. Gue Oracle. Tanya apa aja soal keributan ini.' }],
    isAiLoading: false,
    
    // --- PLAYER STATE ---
    isPlaying: false,
    currentTrackIdx: 0,
    audioObj: null,
    tracks: serverTracks || [], 

    // --- DATA UTAMA ---
    lineup: serverLineup,
    tickets: serverTickets,
    settings: serverSettings,
    
    // --- STATE CHECKOUT ---
    checkoutOpen: false,
    selectedTicket: null,
    checkoutForm: { name: '', email: '', phone: '', qty: 1 },

    // --- STATE CEK STATUS ---
    checkCode: '',
    checkResult: null,

    // State Tambahan
    hoveredArtist: null, 
    newsletterEmail: '',
    newsletterStatus: '',

    // --- HELPER ---
    get activeTheme() { 
        return {
            primary: this.settings.primary_color,
            secondary: this.settings.secondary_color,
            bg: this.settings.background_color,
            text: '#e0e0e0',
            cardBg: '#111111',
            patternOpacity: 0.2
        };
    },

    get currentTrack() {
        return this.tracks[this.currentTrackIdx] || { title: 'NO SIGNAL', artist: 'OFFLINE' };
    },

    get estimatedTotal() {
        if (!this.selectedTicket) return 0;
        let priceStr = this.selectedTicket.price.toUpperCase();
        let price = 0;
        if (priceStr.includes('K')) {
            price = parseInt(priceStr.replace(/[^0-9]/g, '')) * 1000;
        } else {
            price = parseInt(priceStr.replace(/[^0-9]/g, '')) || 0;
        }
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(price * this.checkoutForm.qty);
    },

    // --- INIT ---
    init() {
        document.documentElement.style.setProperty('--primary-color', this.settings.primary_color);
        const token = document.querySelector('meta[name="csrf-token"]');
        if (!token) console.error("⚠️ CSRF TOKEN MISSING");

        const eventDateStr = this.settings.event_date;
        if (eventDateStr) {
            const targetDate = new Date(eventDateStr).getTime();
            setInterval(() => {
                const now = new Date().getTime();
                const d = targetDate - now;
                if (d > 0) {
                    this.timeLeft = {
                        HARI: Math.floor(d / (1000 * 60 * 60 * 24)),
                        JAM: Math.floor((d % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                        MENIT: Math.floor((d % (1000 * 60 * 60)) / (1000 * 60)),
                        DETIK: Math.floor((d % (1000 * 60)) / 1000)
                    };
                } else {
                    this.timeLeft = { HARI: 0, JAM: 0, MENIT: 0, DETIK: 0 };
                }
            }, 1000);
        }

        this.$watch('menuOpen', () => this.refreshIcons());
        this.$watch('chatOpen', () => this.refreshIcons());
        this.$watch('isPlaying', () => this.refreshIcons());
        this.refreshIcons();
    },

    refreshIcons() { setTimeout(() => createIcons({ icons }), 50); },
    handleMouseMove(e) {
        this.mousePos.x = (e.clientX / window.innerWidth) * 2 - 1;
        this.mousePos.y = (e.clientY / window.innerHeight) * 2 - 1;
    },

    // --- LOGIC CEK STATUS (UPDATED: DEBUGGING) ---
    async checkTransaction() {
        let rawInput = this.checkCode.trim();

        if (!rawInput) return;
        
        this.checkResult = null; 
        
        try {
            console.log("🔍 Checking:", rawInput); 

            // Kirim ke Controller
            const response = await window.axios.post('/ticket/check-status', { 
                code: rawInput 
            });
            
            this.checkResult = response.data;
            console.log("✅ Result:", response.data);
            
        } catch (e) {
            console.error("❌ Check Error:", e);
            
            // Tangkap pesan error spesifik dari server (jika ada)
            let errorMessage = "DATA GAK KETEMU.";
            if (e.response && e.response.data && e.response.data.message) {
                errorMessage = e.response.data.message;
            }

            // Simpan status error dan pesannya biar bisa ditampilkan (kalau view support)
            // Atau minimal console log biar kita tau kenapa
            console.warn("Server Message:", errorMessage);

            this.checkResult = { status: 'error', message: errorMessage };
        }
    },

    // --- LOGIC CHECKOUT ---
    openCheckout(ticket) {
        this.selectedTicket = ticket;
        this.checkoutForm.qty = 1; 
        this.checkoutOpen = true;
    },

    closeCheckout() {
        this.checkoutOpen = false;
        setTimeout(() => this.selectedTicket = null, 300);
    },

    // --- PLAYER LOGIC ---
    togglePlay() { 
        if (this.tracks.length === 0) {
            alert("⚠️ Playlist Kosong! Upload lagu dulu di Admin Panel.");
            return;
        }
        if (!this.audioObj) {
            const url = this.tracks[this.currentTrackIdx].url;
            this.audioObj = new Audio(url);
            this.audioObj.addEventListener('error', (e) => { alert("Gagal putar lagu. Link rusak."); this.isPlaying = false; });
            this.audioObj.addEventListener('ended', () => this.nextTrack());
        }
        if (this.isPlaying) { this.audioObj.pause(); this.isPlaying = false; } 
        else { this.audioObj.play(); this.isPlaying = true; }
    },

    nextTrack() { 
        if (this.tracks.length === 0) return;
        this.currentTrackIdx = (this.currentTrackIdx + 1) % this.tracks.length;
        this.changeSource();
    },

    prevTrack() { 
        if (this.tracks.length === 0) return;
        this.currentTrackIdx = (this.currentTrackIdx - 1 + this.tracks.length) % this.tracks.length;
        this.changeSource();
    },

    changeSource() {
        if(this.audioObj) {
            this.audioObj.src = this.tracks[this.currentTrackIdx].url;
            if(this.isPlaying) this.audioObj.play();
        }
        this.refreshIcons();
    },

    // --- NEWSLETTER & CHAT ---
    async submitNewsletter() {
        if (!this.newsletterEmail) return;
        try {
            await window.axios.post('/subscribe', { email: this.newsletterEmail });
            this.newsletterStatus = 'SUCCESS';
            this.newsletterEmail = '';
            setTimeout(() => this.newsletterStatus = '', 3000);
        } catch (e) { this.newsletterStatus = 'ERROR'; }
    },

    async handleSend() {
        if (!this.inputMsg.trim()) return;
        const userText = this.inputMsg;
        this.messages.push({ role: 'user', text: userText });
        this.inputMsg = '';
        this.isAiLoading = true;
        this.scrollToBottom();
        try {
            const response = await window.axios.post('/api/chat', { message: userText, theme: 'Custom' });
            this.messages.push({ role: 'model', text: response.data.reply });
        } catch (e) { 
            this.messages.push({ role: 'model', text: "SISTEM ERROR." }); 
        } finally { 
            this.isAiLoading = false; this.scrollToBottom(); 
        }
    },

    scrollToBottom() {
        setTimeout(() => {
             const el = document.getElementById('chat-container');
             if(el) el.scrollTop = el.scrollHeight;
        }, 50);
    }
}));

Alpine.start();
createIcons({ icons });