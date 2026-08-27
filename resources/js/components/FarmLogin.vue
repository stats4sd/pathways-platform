<template>

<form method="POST" :action="loginRoute">

    <div class="d-flex flex-column justify-content-center align-items-center">

        <div v-if="step === 1" class="w-100 text-center">

            <h3>Cikɛda numerɔ kunafoni ta ni kamera ye</h3>

            <img src="images/qr_code.png" id="image_qr" width="35"/>
            <br/><br/>

            <video
                id="preview"
                class="m-4 w-100"
            />

            <p class="text-muted">
                Cikɛda numerɔ kunafoni bɛ kɛ kamera la
            </p>

            <!-- QR ERROR -->
            <p v-if="qrError" class="text-danger">
                {{ qrError }}
            </p>

        </div>

        <div v-if="step === 2" class="w-100 text-center">

            <h3>Cikɛda numerɔ kunafoni ta ni kamera ye</h3>

            <img src="images/qr_code.png" id="image_qr" width="35"/>
            <br/><br/>

            <h4 class="text-success d-flex justify-content-center align-items-center">
                <i class="la la-check-circle font-weight-bold font-5xl text-success"></i>
                Cikɛda numerɔ tala
            </h4>

            <br/><br/>
            <h3>Cikɛda talefone numerɔ don</h3>

            <img src="images/phone_number.png" id="image_phone" width="35"/>
            <br/><br/>



            <input
                class="form-control mt-4"
                name="phone_number_text"
                v-model="phoneNumberText"
            >

            <p
                v-for="error in phoneNumberErrors"
                class="help-block text-danger"
            >
                {{ error }}
            </p>

        </div>

        <p
            v-for="error in codeErrors"
            class="help-block text-danger"
        >
            {{ error }}
        </p>

        <!-- ================= HIDDEN INPUTS ================= -->
        <input type="hidden" name="phone_number" :value="phoneNumber"/>
        <input type="hidden" name="code" :value="scannedCode"/>
        <input type="hidden" name="_token" :value="csrf">

        <!-- ================= SUBMIT ================= -->
        <button
            v-if="step === 2"
            type="submit"
            class="mt-4 mb-5 btn"
            :class="phoneNumber ? 'btn-primary' : 'btn-secondary'"
            :disabled="!phoneNumber"
        >
            Yɛlɛ a kan
        </button>

    </div>

</form>

</template>

<script setup>

    import QrScanner from 'qr-scanner'
    import { computed, onMounted, onUnmounted, ref } from "vue"

    const props = defineProps({
        loginRoute: String,
        codeErrors: Array,
        phoneNumberErrors: Array,
        oldPhoneNumber: String,
        farmStep: Number,
        scannedCode: String,
    })

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    const step = ref(Number(props.farmStep ?? 1))
    const scannedCode = ref(props.scannedCode ?? '')
    const phoneNumberText = ref('')
    const qrError = ref('')

    let qrScanner = null

    // guards so continuous scan callbacks don't spam the server:
    // only one check in flight, and the same code is not re-checked within the cooldown
    let checking = false
    let lastCheck = { code: null, at: 0 }
    const RECHECK_COOLDOWN_MS = 3000

    const phoneNumber = computed(() =>
        phoneNumberText.value.replaceAll(/\D/ig, '')
    )


    const validateQr = async (code) => {

        try {
            const res = await fetch('/api/farm/check-code', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code })
            })

            return res.ok

        } catch (e) {
            return false
        }
    }

    const handleScan = async (result) => {

        const code = result?.data ?? result

        if (checking) return

        if (code === lastCheck.code && Date.now() - lastCheck.at < RECHECK_COOLDOWN_MS) return

        checking = true
        lastCheck = { code, at: Date.now() }
        qrError.value = ''

        const isValid = await validateQr(code)

        checking = false

        if (!isValid) {
            qrError.value = 'Nin numero dia ɲi ma lakodon. Segi a ka tuguni.'
            return
        }

        scannedCode.value = code
        stopScanner()
        step.value = 2
    }

    const startScanner = async () => {

        const video = document.getElementById('preview')

        if (!video || qrScanner) return

        qrScanner = new QrScanner(
            video,
            result => handleScan(result),
            {
                returnDetailedScanResult: true,
            }
        )

        try {
            await qrScanner.start()
        } catch (err) {
            console.log('camera error', err)
        }
    }

    const stopScanner = () => {

        if (qrScanner) {
            qrScanner.stop()
            qrScanner.destroy()
            qrScanner = null
        }
    }

    onMounted(async () => {

        if (props.oldPhoneNumber) {
            phoneNumberText.value = props.oldPhoneNumber
        }

        // the video element only exists on step 1 — e.g. after a failed
        // phone attempt the page mounts directly on step 2
        if (step.value === 1) {
            startScanner()
        }
    })

    onUnmounted(stopScanner)

</script>
