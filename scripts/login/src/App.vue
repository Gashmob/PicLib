<!--
  - MIT License
  -
  - Copyright (c) 2024-Present Kevin Traini
  -
  - Permission is hereby granted, free of charge, to any person obtaining a copy
  - of this software and associated documentation files (the "Software"), to deal
  - in the Software without restriction, including without limitation the rights
  - to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  - copies of the Software, and to permit persons to whom the Software is
  - furnished to do so, subject to the following conditions:
  -
  - The above copyright notice and this permission notice shall be included in all
  - copies or substantial portions of the Software.
  -
  - THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  - IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  - FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  - AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  - LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  - OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  - SOFTWARE.
  -->
<template>
    <div class="w-screen h-screen flex items-center justify-center">
        <Card class="w-80 p-2">
            <template #title>Administration login</template>
            <template #content>
                <Form v-slot="$form" class="flex flex-col gap-4" @submit="submitForm($event)" method="post" action="">
                    <Password name="password" placeholder="Password" required fluid :feedback="false" data-test="password-input" />
                    <Button type="submit" severity="primary" label="Login" data-test="submit-button" />
                </Form>
            </template>
        </Card>
    </div>
</template>

<script setup lang="ts">
import { Form, FormSubmitEvent } from "@primevue/forms";
import { Button, Card, Password } from "primevue";

const submitForm = (event: FormSubmitEvent) => {
    let original_event = event.originalEvent;
    if (original_event.type === "submit" && original_event.target !== null
        && "submit" in original_event.target && typeof original_event.target.submit === "function") {
        original_event.target.submit();
    }
}
</script>
