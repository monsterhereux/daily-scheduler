import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import idLocale from '@fullcalendar/core/locales/id'
import axios from 'axios'

// helper aman ambil element
function el(id) {
    return document.getElementById(id)
}

let selected = null

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = el('calendar')
    if (!calendarEl) return

    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        selectable: true,

        // 🌍 BAHASA INDONESIA
        locale: 'id',
        locales: [idLocale],

        // 🗓️ TEKS TOMBOL (OPSIONAL, BIAR LEBIH NATURAL)
        buttonText: {
            today: 'Hari ini',
            month: 'Bulan',
            week: 'Minggu',
            day: 'Hari'
        },

        // =====================
        // AMBIL EVENT DARI API
        // =====================
        events: {
            url: '/api/activities',
            failure() {
                alert('Gagal memuat data aktivitas')
            }
        },

        // =====================
        // TANGGAL KOSONG
        // =====================
        select(info) {
            selected = info
            openFormMode()
        },

        // =====================
        // TANGGAL ADA AKTIVITAS
        // =====================
        eventClick(info) {
            const date = info.event.startStr.substring(0, 10)
            selected = { startStr: date, endStr: date }
            openChoiceMode(date)
        }
    })

    // =====================
    // TOMBOL CLOSE (❌)
    // =====================
    el('closeModal')?.addEventListener('click', closeModal)

    // =====================
    // SIMPAN AKTIVITAS
    // =====================
    el('saveActivity')?.addEventListener('click', () => {
        const title = el('title')?.value
        const priority = el('priority')?.value
        const description = el('description')?.value
        const startTime = el('start_time')?.value
        const endTime = el('end_time')?.value

        if (!title || !priority || !startTime || !endTime) {
            alert('Semua field wajib diisi')
            return
        }

        axios.post('/activities', {
            title: title,
            priority: priority,
            description: description,
            start: selected.startStr + ' ' + startTime,
            end: selected.startStr + ' ' + endTime,
        })
        .then(res => {
            closeModal()
            showSuccess(res.data.message || 'Aktivitas berhasil disimpan')
            calendar.refetchEvents()
            resetForm()
        })
        .catch(err => {
            console.error(err)
            alert(err.response?.data?.message || 'Gagal menyimpan aktivitas')
        })
    })

    calendar.render()
})

/* =====================
   HELPER FUNCTIONS
===================== */

function openChoiceMode(date) {
    if (!el('activityModal')) return

    el('activityModal').classList.remove('hidden')
    el('choiceMode')?.classList.remove('hidden')
    el('formMode')?.classList.add('hidden')

    el('btnEdit')?.addEventListener('click', () => {
        window.location.href = `/activities/date/${date}`
    }, { once: true })

    el('btnAddNew')?.addEventListener('click', () => {
        openFormMode()
    }, { once: true })
}

function openFormMode() {
    if (!el('activityModal')) return

    el('activityModal').classList.remove('hidden')
    el('choiceMode')?.classList.add('hidden')
    el('formMode')?.classList.remove('hidden')
}

function closeModal() {
    el('activityModal')?.classList.add('hidden')
    el('choiceMode')?.classList.add('hidden')
    el('formMode')?.classList.remove('hidden')
}

function showSuccess(message) {
    const alertBox = el('successAlert')
    if (!alertBox) return

    alertBox.innerText = message
    alertBox.classList.remove('hidden')

    setTimeout(() => {
        alertBox.classList.add('hidden')
    }, 3000)
}

function resetForm() {
    el('title') && (el('title').value = '')
    el('description') && (el('description').value = '')
    el('start_time') && (el('start_time').value = '')
    el('end_time') && (el('end_time').value = '')
}
