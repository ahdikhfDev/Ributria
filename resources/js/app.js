import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
// import axios from 'axios'; // KITA HAPUS BIAR PAKE BAWAAN LARAVEL

window.Alpine = Alpine;

Alpine.data('appData', (serverLineup, serverTickets, serverSettings, serverTracks) => ({
    menuOpen: false,
    mousePos: { x: 0, y: 0 },
    timeLeft: { HARI: 0, JAM: 0, MENIT: 0, DETIK: 0 },
    chatOpen: false,
    inputMsg: '',
    messages: [{ role: 'model', text: 'SISTEM ONLINE. Gue Oracle. Tanya apa aja soal keributan ini.' }],
    isAiLoading: false,
    
    // PLAYER STATE
    isPlaying: false,
    currentTrackIdx: 0,
    audioObj: null,
    tracks: serverTracks || [], 

    // Data Lain
    lineup: serverLineup,
    tickets: serverTickets,
    settings: serverSettings,
    
    // PERBAIKAN 1: Tambahkan ini biar tidak error "hoveredArtist is not defined"
    hoveredArtist: null, 
    
    // Newsletter State
    newsletterEmail: '',
    newsletterStatus: '',

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

    init() {
        document.documentElement.style.setProperty('--primary-color', this.settings.primary_color);
        
        console.log("🎵 Playlist Loaded:", this.tracks);

        // Cek Token CSRF
        const token = document.querySelector('meta[name="csrf-token"]');
        if (!token) {
            console.error("⚠️ CSRF TOKEN TIDAK DITEMUKAN DI <HEAD>! Form tidak akan jalan.");
        }

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

    // PLAYER LOGIC
    togglePlay() { 
        if (this.tracks.length === 0) {
            alert("⚠️ Playlist Kosong! Upload lagu dulu di Admin Panel.");
            return;
        }

        if (!this.audioObj) {
            const url = this.tracks[this.currentTrackIdx].url;
            this.audioObj = new Audio(url);
            
            this.audioObj.addEventListener('error', (e) => {
                console.error("❌ Audio Error:", e);
                alert("Gagal memutar lagu. Link mungkin rusak.");
                this.isPlaying = false;
            });

            this.audioObj.addEventListener('ended', () => {
                this.nextTrack();
            });
        }

        if (this.isPlaying) {
            this.audioObj.pause();
            this.isPlaying = false;
        } else {
            this.audioObj.play().catch(e => {
                console.error("Play Error:", e);
                this.isPlaying = false;
            });
            this.isPlaying = true;
        }
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

    // NEWSLETTER
    async submitNewsletter() {
        if (!this.newsletterEmail) return;
        
        try {
            // PERBAIKAN 2: Gunakan window.axios agar CSRF Token terbawa
            await window.axios.post('/subscribe', { email: this.newsletterEmail });
            
            this.newsletterStatus = 'SUCCESS';
            this.newsletterEmail = '';
            setTimeout(() => this.newsletterStatus = '', 3000);
        } catch (e) {
            console.error("Submit Error:", e);
            this.newsletterStatus = 'ERROR';
        }
    },

    // CHAT
    async handleSend() {
        if (!this.inputMsg.trim()) return;
        const userText = this.inputMsg;
        this.messages.push({ role: 'user', text: userText });
        this.inputMsg = '';
        this.isAiLoading = true;
        this.scrollToBottom();

        try {
            // PERBAIKAN 3: Gunakan window.axios
            const response = await window.axios.post('/api/chat', {
                message: userText,
                theme: 'Custom' 
            });
            this.messages.push({ role: 'model', text: response.data.reply });
        } catch (error) {
            console.error("Chat Error:", error);
            this.messages.push({ role: 'model', text: "SISTEM ERROR: Cek koneksi server." });
        } finally {
            this.isAiLoading = false;
            this.scrollToBottom();
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