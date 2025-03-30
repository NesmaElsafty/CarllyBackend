<!DOCTYPE html>
<!-- saved from url=(0022)http://localhost:5173/ -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <script type="module">
    import RefreshRuntime from "/@react-refresh"
    RefreshRuntime.injectIntoGlobalHook(window)
    window.$RefreshReg$ = () => {}
    window.$RefreshSig$ = () => (type) => type
    window.__vite_plugin_react_preamble_installed__ = true
    </script>

    <script type="module" src="./Carsillalogin_files/client"></script>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="./Carsillalogin_files/css2" rel="stylesheet">
    <title>Carsilla</title>
    <style type="text/css" data-vite-dev-id="C:/xampp/htdocs/carsillareactjs/src/App.css"></style>
    <style type="text/css"
        data-vite-dev-id="C:/xampp/htdocs/carsillareactjs/node_modules/react-responsive-modal/styles.css">
    .react-responsive-modal-root {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
    }

    .react-responsive-modal-overlay {
        background: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: -1;
    }

    .react-responsive-modal-container {
        height: 100%;
        outline: 0;
        overflow-x: hidden;
        overflow-y: auto;
        text-align: center;
    }

    /* Used to trick the browser to center the modal content properly  */
    .react-responsive-modal-containerCenter:after {
        width: 0;
        height: 100%;
        content: '';
        display: inline-block;
        vertical-align: middle;
    }

    .react-responsive-modal-modal {
        max-width: 800px;
        display: inline-block;
        text-align: left;
        vertical-align: middle;
        background: #ffffff;
        box-shadow: 0 12px 15px 0 rgba(0, 0, 0, 0.25);
        margin: 1.2rem;
        padding: 1.2rem;
        position: relative;
        overflow-y: auto;
    }

    .react-responsive-modal-closeButton {
        position: absolute;
        top: 14px;
        right: 14px;
        border: none;
        padding: 0;
        cursor: pointer;
        background-color: transparent;
        display: flex;
    }

    /* Used to fix a screen glitch issues with the animation see https://github.com/pradel/react-responsive-modal/issues/495 */
    .react-responsive-modal-overlay,
    .react-responsive-modal-container,
    .react-responsive-modal-modal {
        animation-fill-mode: forwards !important;
    }

    @keyframes react-responsive-modal-overlay-in {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes react-responsive-modal-overlay-out {
        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    @keyframes react-responsive-modal-modal-in {
        0% {
            transform: scale(0.96);
            opacity: 0;
        }

        100% {
            transform: scale(100%);
            opacity: 1;
        }
    }

    @keyframes react-responsive-modal-modal-out {
        0% {
            transform: scale(100%);
            opacity: 1;
        }

        100% {
            transform: scale(0.96);
            opacity: 0;
        }
    }
    </style>
    <style type="text/css" data-vite-dev-id="C:/xampp/htdocs/carsillareactjs/src/index.css">
    /*
! tailwindcss v3.3.5 | MIT License | https://tailwindcss.com
*/
    /*
1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
*/

    *,
    ::before,
    ::after {
        box-sizing: border-box;
        /* 1 */
        border-width: 0;
        /* 2 */
        border-style: solid;
        /* 2 */
        border-color: #e5e7eb;
        /* 2 */
    }

    ::before,
    ::after {
        --tw-content: '';
    }

    /*
1. Use a consistent sensible line-height in all browsers.
2. Prevent adjustments of font size after orientation changes in iOS.
3. Use a more readable tab size.
4. Use the user's configured `sans` font-family by default.
5. Use the user's configured `sans` font-feature-settings by default.
6. Use the user's configured `sans` font-variation-settings by default.
*/

    html {
        line-height: 1.5;
        /* 1 */
        -webkit-text-size-adjust: 100%;
        /* 2 */
        -moz-tab-size: 4;
        /* 3 */
        -o-tab-size: 4;
        tab-size: 4;
        /* 3 */
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        /* 4 */
        font-feature-settings: normal;
        /* 5 */
        font-variation-settings: normal;
        /* 6 */
    }

    /*
1. Remove the margin in all browsers.
2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
*/

    body {
        margin: 0;
        /* 1 */
        line-height: inherit;
        /* 2 */
    }

    /*
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
3. Ensure horizontal rules are visible by default.
*/

    hr {
        height: 0;
        /* 1 */
        color: inherit;
        /* 2 */
        border-top-width: 1px;
        /* 3 */
    }

    /*
Add the correct text decoration in Chrome, Edge, and Safari.
*/

    abbr:where([title]) {
        -webkit-text-decoration: underline dotted;
        text-decoration: underline dotted;
    }

    /*
Remove the default font size and weight for headings.
*/

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-size: inherit;
        font-weight: inherit;
    }

    /*
Reset links to optimize for opt-in styling instead of opt-out.
*/

    a {
        color: inherit;
        text-decoration: inherit;
    }

    /*
Add the correct font weight in Edge and Safari.
*/

    b,
    strong {
        font-weight: bolder;
    }

    /*
1. Use the user's configured `mono` font family by default.
2. Correct the odd `em` font sizing in all browsers.
*/

    code,
    kbd,
    samp,
    pre {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        /* 1 */
        font-size: 1em;
        /* 2 */
    }

    /*
Add the correct font size in all browsers.
*/

    small {
        font-size: 80%;
    }

    /*
Prevent `sub` and `sup` elements from affecting the line height in all browsers.
*/

    sub,
    sup {
        font-size: 75%;
        line-height: 0;
        position: relative;
        vertical-align: baseline;
    }

    sub {
        bottom: -0.25em;
    }

    sup {
        top: -0.5em;
    }

    /*
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
3. Remove gaps between table borders by default.
*/

    table {
        text-indent: 0;
        /* 1 */
        border-color: inherit;
        /* 2 */
        border-collapse: collapse;
        /* 3 */
    }

    /*
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
3. Remove default padding in all browsers.
*/

    button,
    input,
    optgroup,
    select,
    textarea {
        font-family: inherit;
        /* 1 */
        font-feature-settings: inherit;
        /* 1 */
        font-variation-settings: inherit;
        /* 1 */
        font-size: 100%;
        /* 1 */
        font-weight: inherit;
        /* 1 */
        line-height: inherit;
        /* 1 */
        color: inherit;
        /* 1 */
        margin: 0;
        /* 2 */
        padding: 0;
        /* 3 */
    }

    /*
Remove the inheritance of text transform in Edge and Firefox.
*/

    button,
    select {
        text-transform: none;
    }

    /*
1. Correct the inability to style clickable types in iOS and Safari.
2. Remove default button styles.
*/

    button,
    [type='button'],
    [type='reset'],
    [type='submit'] {
        -webkit-appearance: button;
        /* 1 */
        background-color: transparent;
        /* 2 */
        background-image: none;
        /* 2 */
    }

    /*
Use the modern Firefox focus style for all focusable elements.
*/

    :-moz-focusring {
        outline: auto;
    }

    /*
Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
*/

    :-moz-ui-invalid {
        box-shadow: none;
    }

    /*
Add the correct vertical alignment in Chrome and Firefox.
*/

    progress {
        vertical-align: baseline;
    }

    /*
Correct the cursor style of increment and decrement buttons in Safari.
*/

    ::-webkit-inner-spin-button,
    ::-webkit-outer-spin-button {
        height: auto;
    }

    /*
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/

    [type='search'] {
        -webkit-appearance: textfield;
        /* 1 */
        outline-offset: -2px;
        /* 2 */
    }

    /*
Remove the inner padding in Chrome and Safari on macOS.
*/

    ::-webkit-search-decoration {
        -webkit-appearance: none;
    }

    /*
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to `inherit` in Safari.
*/

    ::-webkit-file-upload-button {
        -webkit-appearance: button;
        /* 1 */
        font: inherit;
        /* 2 */
    }

    /*
Add the correct display in Chrome and Safari.
*/

    summary {
        display: list-item;
    }

    /*
Removes the default spacing and border for appropriate elements.
*/

    blockquote,
    dl,
    dd,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr,
    figure,
    p,
    pre {
        margin: 0;
    }

    fieldset {
        margin: 0;
        padding: 0;
    }

    legend {
        padding: 0;
    }

    ol,
    ul,
    menu {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /*
Reset default styling for dialogs.
*/
    dialog {
        padding: 0;
    }

    /*
Prevent resizing textareas horizontally by default.
*/

    textarea {
        resize: vertical;
    }

    /*
1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
2. Set the default placeholder color to the user's configured gray 400 color.
*/

    input::-moz-placeholder,
    textarea::-moz-placeholder {
        opacity: 1;
        /* 1 */
        color: #9ca3af;
        /* 2 */
    }

    input::placeholder,
    textarea::placeholder {
        opacity: 1;
        /* 1 */
        color: #9ca3af;
        /* 2 */
    }

    /*
Set the default cursor for buttons.
*/

    button,
    [role="button"] {
        cursor: pointer;
    }

    /*
Make sure disabled buttons don't get the pointer cursor.
*/
    :disabled {
        cursor: default;
    }

    /*
1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
   This can trigger a poorly considered lint error in some tools but is included by design.
*/

    img,
    svg,
    video,
    canvas,
    audio,
    iframe,
    embed,
    object {
        display: block;
        /* 1 */
        vertical-align: middle;
        /* 2 */
    }

    /*
Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
*/

    img,
    video {
        max-width: 100%;
        height: auto;
    }

    /* Make elements with the HTML hidden attribute stay hidden by default */
    [hidden] {
        display: none;
    }

    *,
    ::before,
    ::after {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
    }

    ::backdrop {
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgb(59 130 246 / 0.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-shadow: 0 0 #0000;
        --tw-shadow-colored: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
    }

    .fixed {
        position: fixed;
    }

    .absolute {
        position: absolute;
    }

    .relative {
        position: relative;
    }

    .inset-0 {
        inset: 0px;
    }

    .-bottom-0 {
        bottom: -0px;
    }

    .-right-2 {
        right: -0.5rem;
    }

    .-right-3 {
        right: -0.75rem;
    }

    .-top-4 {
        top: -1rem;
    }

    .-top-5 {
        top: -1.25rem;
    }

    .bottom-0 {
        bottom: 0px;
    }

    .left-0 {
        left: 0px;
    }

    .left-\[21\%\] {
        left: 21%;
    }

    .right-0 {
        right: 0px;
    }

    .right-5 {
        right: 1.25rem;
    }

    .right-\[1px\] {
        right: 1px;
    }

    .right-\[50\%\] {
        right: 50%;
    }

    .top-1\/3 {
        top: 33.333333%;
    }

    .top-32 {
        top: 8rem;
    }

    .top-36 {
        top: 9rem;
    }

    .top-7 {
        top: 1.75rem;
    }

    .top-\[1px\] {
        top: 1px;
    }

    .z-10 {
        z-index: 10;
    }

    .z-20 {
        z-index: 20;
    }

    .z-40 {
        z-index: 40;
    }

    .z-50 {
        z-index: 50;
    }

    .float-right {
        float: right;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .my-3 {
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .my-6 {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .mb-5 {
        margin-bottom: 1.25rem;
    }

    .ml-10 {
        margin-left: 2.5rem;
    }

    .ml-2 {
        margin-left: 0.5rem;
    }

    .block {
        display: block;
    }

    .flex {
        display: flex;
    }

    .table {
        display: table;
    }

    .grid {
        display: grid;
    }

    .hidden {
        display: none;
    }

    .h-\[1\.5rem\] {
        height: 1.5rem;
    }

    .h-\[107px\] {
        height: 107px;
    }

    .h-\[10px\] {
        height: 10px;
    }

    .h-\[13px\] {
        height: 13px;
    }

    .h-\[156px\] {
        height: 156px;
    }

    .h-\[157px\] {
        height: 157px;
    }

    .h-\[15rem\] {
        height: 15rem;
    }

    .h-\[16px\] {
        height: 16px;
    }

    .h-\[1rem\] {
        height: 1rem;
    }

    .h-\[2\.8125rem\] {
        height: 2.8125rem;
    }

    .h-\[230px\] {
        height: 230px;
    }

    .h-\[270px\] {
        height: 270px;
    }

    .h-\[28px\] {
        height: 28px;
    }

    .h-\[2rem\] {
        height: 2rem;
    }

    .h-\[31\.08px\] {
        height: 31.08px;
    }

    .h-\[33px\] {
        height: 33px;
    }

    .h-\[37px\] {
        height: 37px;
    }

    .h-\[38px\] {
        height: 38px;
    }

    .h-\[40px\] {
        height: 40px;
    }

    .h-\[44px\] {
        height: 44px;
    }

    .h-\[46px\] {
        height: 46px;
    }

    .h-\[60px\] {
        height: 60px;
    }

    .h-\[624px\] {
        height: 624px;
    }

    .h-auto {
        height: auto;
    }

    .h-full {
        height: 100%;
    }

    .h-screen {
        height: 100vh;
    }

    .max-h-\[30vh\] {
        max-height: 30vh;
    }

    .max-h-screen {
        max-height: 100vh;
    }

    .min-h-\[100vh\] {
        min-height: 100vh;
    }

    .min-h-screen {
        min-height: 100vh;
    }

    .w-\[1\.5rem\] {
        width: 1.5rem;
    }

    .w-\[10px\] {
        width: 10px;
    }

    .w-\[110px\] {
        width: 110px;
    }

    .w-\[119px\] {
        width: 119px;
    }

    .w-\[138\.75px\] {
        width: 138.75px;
    }

    .w-\[13px\] {
        width: 13px;
    }

    .w-\[176px\] {
        width: 176px;
    }

    .w-\[1px\] {
        width: 1px;
    }

    .w-\[1rem\] {
        width: 1rem;
    }

    .w-\[2\.8125rem\] {
        width: 2.8125rem;
    }

    .w-\[200px\] {
        width: 200px;
    }

    .w-\[250px\] {
        width: 250px;
    }

    .w-\[2rem\] {
        width: 2rem;
    }

    .w-\[300px\] {
        width: 300px;
    }

    .w-\[33px\] {
        width: 33px;
    }

    .w-\[36px\] {
        width: 36px;
    }

    .w-\[37px\] {
        width: 37px;
    }

    .w-\[40px\] {
        width: 40px;
    }

    .w-\[44px\] {
        width: 44px;
    }

    .w-\[46px\] {
        width: 46px;
    }

    .w-\[48\%\] {
        width: 48%;
    }

    .w-\[52px\] {
        width: 52px;
    }

    .w-\[53\%\] {
        width: 53%;
    }

    .w-\[60\%\] {
        width: 60%;
    }

    .w-\[60px\] {
        width: 60px;
    }

    .w-\[70\%\] {
        width: 70%;
    }

    .w-\[70px\] {
        width: 70px;
    }

    .w-\[80\%\] {
        width: 80%;
    }

    .w-\[83px\] {
        width: 83px;
    }

    .w-\[88px\] {
        width: 88px;
    }

    .w-\[90\%\] {
        width: 90%;
    }

    .w-\[97px\] {
        width: 97px;
    }

    .w-full {
        width: 100%;
    }

    .min-w-full {
        min-width: 100%;
    }

    .-translate-x-full {
        --tw-translate-x: -100%;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }

    .translate-x-0 {
        --tw-translate-x: 0px;
        transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .flex-row {
        flex-direction: row;
    }

    .flex-col {
        flex-direction: column;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .items-start {
        align-items: flex-start;
    }

    .items-center {
        align-items: center;
    }

    .justify-start {
        justify-content: flex-start;
    }

    .justify-end {
        justify-content: flex-end;
    }

    .justify-center {
        justify-content: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .gap-3 {
        gap: 0.75rem;
    }

    .gap-4 {
        gap: 1rem;
    }

    .gap-6 {
        gap: 1.5rem;
    }

    .gap-8 {
        gap: 2rem;
    }

    .gap-x-2 {
        -moz-column-gap: 0.5rem;
        column-gap: 0.5rem;
    }

    .gap-x-20 {
        -moz-column-gap: 5rem;
        column-gap: 5rem;
    }

    .gap-x-3 {
        -moz-column-gap: 0.75rem;
        column-gap: 0.75rem;
    }

    .gap-x-4 {
        -moz-column-gap: 1rem;
        column-gap: 1rem;
    }

    .gap-x-8 {
        -moz-column-gap: 2rem;
        column-gap: 2rem;
    }

    .gap-y-2 {
        row-gap: 0.5rem;
    }

    .gap-y-3 {
        row-gap: 0.75rem;
    }

    .gap-y-4 {
        row-gap: 1rem;
    }

    .gap-y-6 {
        row-gap: 1.5rem;
    }

    .gap-y-8 {
        row-gap: 2rem;
    }

    .space-y-1> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(0.25rem * var(--tw-space-y-reverse));
    }

    .space-y-2> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
    }

    .space-y-3> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(0.75rem * var(--tw-space-y-reverse));
    }

    .space-y-4> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(1rem * var(--tw-space-y-reverse));
    }

    .space-y-6> :not([hidden])~ :not([hidden]) {
        --tw-space-y-reverse: 0;
        margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
        margin-bottom: calc(1.5rem * var(--tw-space-y-reverse));
    }

    .overflow-x-auto {
        overflow-x: auto;
    }

    .overflow-x-hidden {
        overflow-x: hidden;
    }

    .overflow-y-scroll {
        overflow-y: scroll;
    }

    .rounded-2xl {
        border-radius: 1rem;
    }

    .rounded-\[10px\] {
        border-radius: 10px;
    }

    .rounded-full {
        border-radius: 9999px;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .rounded-md {
        border-radius: 0.375rem;
    }

    .rounded-xl {
        border-radius: 0.75rem;
    }

    .border {
        border-width: 1px;
    }

    .border-2 {
        border-width: 2px;
    }

    .border-\[1px\] {
        border-width: 1px;
    }

    .border-\[2px\] {
        border-width: 2px;
    }

    .border-\[3px\] {
        border-width: 3px;
    }

    .border-b {
        border-bottom-width: 1px;
    }

    .border-b-\[1px\] {
        border-bottom-width: 1px;
    }

    .border-b-\[2px\] {
        border-bottom-width: 2px;
    }

    .border-l {
        border-left-width: 1px;
    }

    .border-r {
        border-right-width: 1px;
    }

    .border-t-\[1px\] {
        border-top-width: 1px;
    }

    .border-none {
        border-style: none;
    }

    .border-\[\#00BA9D\] {
        --tw-border-opacity: 1;
        border-color: rgb(0 186 157 / var(--tw-border-opacity));
    }

    .border-\[\#01C8A9\] {
        --tw-border-opacity: 1;
        border-color: rgb(1 200 169 / var(--tw-border-opacity));
    }

    .border-\[\#C2C2C2\] {
        --tw-border-opacity: 1;
        border-color: rgb(194 194 194 / var(--tw-border-opacity));
    }

    .border-\[\#DCDCDC\] {
        --tw-border-opacity: 1;
        border-color: rgb(220 220 220 / var(--tw-border-opacity));
    }

    .border-\[\#E2E1E1\] {
        --tw-border-opacity: 1;
        border-color: rgb(226 225 225 / var(--tw-border-opacity));
    }

    .border-\[\#EFF1FF\] {
        --tw-border-opacity: 1;
        border-color: rgb(239 241 255 / var(--tw-border-opacity));
    }

    .border-\[\#EFF4FA\] {
        --tw-border-opacity: 1;
        border-color: rgb(239 244 250 / var(--tw-border-opacity));
    }

    .border-\[\#F1F1F1\] {
        --tw-border-opacity: 1;
        border-color: rgb(241 241 241 / var(--tw-border-opacity));
    }

    .border-bGrey {
        --tw-border-opacity: 1;
        border-color: rgb(226 225 225 / var(--tw-border-opacity));
    }

    .border-black {
        --tw-border-opacity: 1;
        border-color: rgb(0 0 0 / var(--tw-border-opacity));
    }

    .border-borderColor {
        --tw-border-opacity: 1;
        border-color: rgb(241 241 241 / var(--tw-border-opacity));
    }

    .border-darkBtn {
        --tw-border-opacity: 1;
        border-color: rgb(14 51 95 / var(--tw-border-opacity));
    }

    .border-darkGrey {
        --tw-border-opacity: 1;
        border-color: rgb(113 113 113 / var(--tw-border-opacity));
    }

    .border-lightBlue {
        --tw-border-opacity: 1;
        border-color: rgb(239 244 250 / var(--tw-border-opacity));
    }

    .border-pink {
        --tw-border-opacity: 1;
        border-color: rgb(255 84 112 / var(--tw-border-opacity));
    }

    .border-textBlue {
        --tw-border-opacity: 1;
        border-color: rgb(3 94 207 / var(--tw-border-opacity));
    }

    .border-textDark {
        --tw-border-opacity: 1;
        border-color: rgb(0 25 59 / var(--tw-border-opacity));
    }

    .border-transparent {
        border-color: transparent;
    }

    .border-white {
        --tw-border-opacity: 1;
        border-color: rgb(255 255 255 / var(--tw-border-opacity));
    }

    .border-b-\[\#EFF4FA\] {
        --tw-border-opacity: 1;
        border-bottom-color: rgb(239 244 250 / var(--tw-border-opacity));
    }

    .border-t-\[\#EFF4FA\] {
        --tw-border-opacity: 1;
        border-top-color: rgb(239 244 250 / var(--tw-border-opacity));
    }

    .bg-\[\#00BA9D\] {
        --tw-bg-opacity: 1;
        background-color: rgb(0 186 157 / var(--tw-bg-opacity));
    }

    .bg-\[\#0A458F\] {
        --tw-bg-opacity: 1;
        background-color: rgb(10 69 143 / var(--tw-bg-opacity));
    }

    .bg-\[\#EFF4FA\] {
        --tw-bg-opacity: 1;
        background-color: rgb(239 244 250 / var(--tw-bg-opacity));
    }

    .bg-\[\#F1F1F1\] {
        --tw-bg-opacity: 1;
        background-color: rgb(241 241 241 / var(--tw-bg-opacity));
    }

    .bg-\[\#F8D518\] {
        --tw-bg-opacity: 1;
        background-color: rgb(248 213 24 / var(--tw-bg-opacity));
    }

    .bg-\[\#F9F9F9\] {
        --tw-bg-opacity: 1;
        background-color: rgb(249 249 249 / var(--tw-bg-opacity));
    }

    .bg-bGrey {
        --tw-bg-opacity: 1;
        background-color: rgb(226 225 225 / var(--tw-bg-opacity));
    }

    .bg-darkBtn {
        --tw-bg-opacity: 1;
        background-color: rgb(14 51 95 / var(--tw-bg-opacity));
    }

    .bg-green {
        --tw-bg-opacity: 1;
        background-color: rgb(2 161 137 / var(--tw-bg-opacity));
    }

    .bg-greyBg {
        --tw-bg-opacity: 1;
        background-color: rgb(249 249 249 / var(--tw-bg-opacity));
    }

    .bg-lightBlue {
        --tw-bg-opacity: 1;
        background-color: rgb(239 244 250 / var(--tw-bg-opacity));
    }

    .bg-pink {
        --tw-bg-opacity: 1;
        background-color: rgb(255 84 112 / var(--tw-bg-opacity));
    }

    .bg-primary {
        --tw-bg-opacity: 1;
        background-color: rgb(164 31 31 / var(--tw-bg-opacity));
    }

    .bg-secondary {
        --tw-bg-opacity: 1;
        background-color: rgb(74 133 246 / var(--tw-bg-opacity));
    }

    .bg-textBlue {
        --tw-bg-opacity: 1;
        background-color: rgb(3 94 207 / var(--tw-bg-opacity));
    }

    .bg-textDark {
        --tw-bg-opacity: 1;
        background-color: rgb(0 25 59 / var(--tw-bg-opacity));
    }

    .bg-textMd {
        --tw-bg-opacity: 1;
        background-color: rgb(39 50 65 / var(--tw-bg-opacity));
    }

    .bg-transparent {
        background-color: transparent;
    }

    .bg-white {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    .object-cover {
        -o-object-fit: cover;
        object-fit: cover;
    }

    .object-center {
        -o-object-position: center;
        object-position: center;
    }

    .object-left {
        -o-object-position: left;
        object-position: left;
    }

    .p-2 {
        padding: 0.5rem;
    }

    .p-4 {
        padding: 1rem;
    }

    .px-10 {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
    }

    .px-2 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .px-3 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .px-5 {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }

    .px-6 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .py-1 {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }

    .py-1\.5 {
        padding-top: 0.375rem;
        padding-bottom: 0.375rem;
    }

    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .py-2\.5 {
        padding-top: 0.625rem;
        padding-bottom: 0.625rem;
    }

    .py-3 {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .py-3\.5 {
        padding-top: 0.875rem;
        padding-bottom: 0.875rem;
    }

    .py-4 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .py-6 {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .py-8 {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .pb-10 {
        padding-bottom: 2.5rem;
    }

    .pb-2 {
        padding-bottom: 0.5rem;
    }

    .pb-4 {
        padding-bottom: 1rem;
    }

    .pb-6 {
        padding-bottom: 1.5rem;
    }

    .pb-8 {
        padding-bottom: 2rem;
    }

    .pl-4 {
        padding-left: 1rem;
    }

    .pr-3 {
        padding-right: 0.75rem;
    }

    .pr-4 {
        padding-right: 1rem;
    }

    .pr-6 {
        padding-right: 1.5rem;
    }

    .pt-10 {
        padding-top: 2.5rem;
    }

    .pt-2 {
        padding-top: 0.5rem;
    }

    .pt-3 {
        padding-top: 0.75rem;
    }

    .pt-4 {
        padding-top: 1rem;
    }

    .pt-6 {
        padding-top: 1.5rem;
    }

    .pt-8 {
        padding-top: 2rem;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .font-archivo {
        font-family: Archivo, sans-serif;
    }

    .font-openSans {
        font-family: Open Sans, sans-serif;
    }

    .font-roboto {
        font-family: Roboto, sans-serif;
    }

    .font-sourceSans {
        font-family: Soruce Sans 3, sans-serif;
    }

    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }

    .text-\[1\.25rem\] {
        font-size: 1.25rem;
    }

    .text-\[1\.2rem\] {
        font-size: 1.2rem;
    }

    .text-\[1\.4rem\] {
        font-size: 1.4rem;
    }

    .text-\[1\.5rem\] {
        font-size: 1.5rem;
    }

    .text-\[10px\] {
        font-size: 10px;
    }

    .text-\[13px\] {
        font-size: 13px;
    }

    .text-\[15px\] {
        font-size: 15px;
    }

    .text-\[17px\] {
        font-size: 17px;
    }

    .text-\[1rem\] {
        font-size: 1rem;
    }

    .text-\[2\.2rem\] {
        font-size: 2.2rem;
    }

    .text-\[2\.38rem\] {
        font-size: 2.38rem;
    }

    .text-\[20px\] {
        font-size: 20px;
    }

    .text-\[22px\] {
        font-size: 22px;
    }

    .text-\[24px\] {
        font-size: 24px;
    }

    .text-\[28px\] {
        font-size: 28px;
    }

    .text-\[2rem\] {
        font-size: 2rem;
    }

    .text-\[32px\] {
        font-size: 32px;
    }

    .text-\[38px\] {
        font-size: 38px;
    }

    .text-base {
        font-size: 1rem;
        line-height: 1.5rem;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }

    .font-\[500\] {
        font-weight: 500;
    }

    .font-bold {
        font-weight: 700;
    }

    .font-normal {
        font-weight: 400;
    }

    .font-semibold {
        font-weight: 600;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .capitalize {
        text-transform: capitalize;
    }

    .leading-\[1\.5rem\] {
        line-height: 1.5rem;
    }

    .leading-\[13\.6px\] {
        line-height: 13.6px;
    }

    .leading-\[14\.14px\] {
        line-height: 14.14px;
    }

    .leading-\[14\.41px\] {
        line-height: 14.41px;
    }

    .leading-\[14\.71px\] {
        line-height: 14.71px;
    }

    .leading-\[15\.23px\] {
        line-height: 15.23px;
    }

    .leading-\[16\.34px\] {
        line-height: 16.34px;
    }

    .leading-\[16\.41px\] {
        line-height: 16.41px;
    }

    .leading-\[16\.94px\] {
        line-height: 16.94px;
    }

    .leading-\[16px\] {
        line-height: 16px;
    }

    .leading-\[17\.41px\] {
        line-height: 17.41px;
    }

    .leading-\[18\.75px\] {
        line-height: 18.75px;
    }

    .leading-\[18px\] {
        line-height: 18px;
    }

    .leading-\[19\.07px\] {
        line-height: 19.07px;
    }

    .leading-\[19\.41px\] {
        line-height: 19.41px;
    }

    .leading-\[19px\] {
        line-height: 19px;
    }

    .leading-\[1rem\] {
        line-height: 1rem;
    }

    .leading-\[2\.25rem\] {
        line-height: 2.25rem;
    }

    .leading-\[20p\] {
        line-height: 20p;
    }

    .leading-\[20px\] {
        line-height: 20px;
    }

    .leading-\[21\.79px\] {
        line-height: 21.79px;
    }

    .leading-\[21px\] {
        line-height: 21px;
    }

    .leading-\[22px\] {
        line-height: 22px;
    }

    .leading-\[23px\] {
        line-height: 23px;
    }

    .leading-\[24px\] {
        line-height: 24px;
    }

    .leading-\[2rem\] {
        line-height: 2rem;
    }

    .leading-\[30px\] {
        line-height: 30px;
    }

    .leading-\[34px\] {
        line-height: 34px;
    }

    .leading-\[36px\] {
        line-height: 36px;
    }

    .leading-\[43\.58px\] {
        line-height: 43.58px;
    }

    .leading-\[51\.75px\] {
        line-height: 51.75px;
    }

    .tracking-\[\.41px\] {
        letter-spacing: .41px;
    }

    .tracking-\[\.4px\] {
        letter-spacing: .4px;
    }

    .tracking-\[0\.15px\] {
        letter-spacing: 0.15px;
    }

    .tracking-\[0\.25px\] {
        letter-spacing: 0.25px;
    }

    .tracking-\[0\.41px\] {
        letter-spacing: 0.41px;
    }

    .tracking-\[0\.4px\] {
        letter-spacing: 0.4px;
    }

    .tracking-\[0\.5px\] {
        letter-spacing: 0.5px;
    }

    .text-\[\#00BA9D\] {
        --tw-text-opacity: 1;
        color: rgb(0 186 157 / var(--tw-text-opacity));
    }

    .text-\[\#02A189\] {
        --tw-text-opacity: 1;
        color: rgb(2 161 137 / var(--tw-text-opacity));
    }

    .text-\[\#1B1B1B\] {
        --tw-text-opacity: 1;
        color: rgb(27 27 27 / var(--tw-text-opacity));
    }

    .text-\[\#202020\] {
        --tw-text-opacity: 1;
        color: rgb(32 32 32 / var(--tw-text-opacity));
    }

    .text-\[\#6E757F\] {
        --tw-text-opacity: 1;
        color: rgb(110 117 127 / var(--tw-text-opacity));
    }

    .text-\[\#8F9BB3\] {
        --tw-text-opacity: 1;
        color: rgb(143 155 179 / var(--tw-text-opacity));
    }

    .text-\[\#C5CEE0\] {
        --tw-text-opacity: 1;
        color: rgb(197 206 224 / var(--tw-text-opacity));
    }

    .text-black {
        --tw-text-opacity: 1;
        color: rgb(0 0 0 / var(--tw-text-opacity));
    }

    .text-darkBtn {
        --tw-text-opacity: 1;
        color: rgb(14 51 95 / var(--tw-text-opacity));
    }

    .text-darkGrey {
        --tw-text-opacity: 1;
        color: rgb(113 113 113 / var(--tw-text-opacity));
    }

    .text-green {
        --tw-text-opacity: 1;
        color: rgb(2 161 137 / var(--tw-text-opacity));
    }

    .text-lightGrey {
        --tw-text-opacity: 1;
        color: rgb(143 155 179 / var(--tw-text-opacity));
    }

    .text-neutral {
        --tw-text-opacity: 1;
        color: rgb(10 10 10 / var(--tw-text-opacity));
    }

    .text-neutralGrey {
        --tw-text-opacity: 1;
        color: rgb(117 117 117 / var(--tw-text-opacity));
    }

    .text-pink {
        --tw-text-opacity: 1;
        color: rgb(255 84 112 / var(--tw-text-opacity));
    }

    .text-profileCard {
        --tw-text-opacity: 1;
        color: rgb(110 117 127 / var(--tw-text-opacity));
    }

    .text-secondary {
        --tw-text-opacity: 1;
        color: rgb(74 133 246 / var(--tw-text-opacity));
    }

    .text-textBlue {
        --tw-text-opacity: 1;
        color: rgb(3 94 207 / var(--tw-text-opacity));
    }

    .text-textBluish {
        --tw-text-opacity: 1;
        color: rgb(34 43 69 / var(--tw-text-opacity));
    }

    .text-textDark {
        --tw-text-opacity: 1;
        color: rgb(0 25 59 / var(--tw-text-opacity));
    }

    .text-textDarkG {
        --tw-text-opacity: 1;
        color: rgb(64 64 64 / var(--tw-text-opacity));
    }

    .text-textGrey {
        --tw-text-opacity: 1;
        color: rgb(141 141 153 / var(--tw-text-opacity));
    }

    .text-textLight {
        --tw-text-opacity: 1;
        color: rgb(81 92 107 / var(--tw-text-opacity));
    }

    .text-textMd {
        --tw-text-opacity: 1;
        color: rgb(39 50 65 / var(--tw-text-opacity));
    }

    .text-white {
        --tw-text-opacity: 1;
        color: rgb(255 255 255 / var(--tw-text-opacity));
    }

    .opacity-\[79\.91\%\] {
        opacity: 79.91%;
    }

    .shadow {
        --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-boxShadow {
        --tw-shadow: 0px 3px 14px 0px #E2E1E1C4;
        --tw-shadow-colored: 0px 3px 14px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-btnShadow {
        --tw-shadow: 2.5px 4.300000190734863px 10px 0px #0000001A;
        --tw-shadow-colored: 2.5px 4.300000190734863px 10px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-btnShadow2 {
        --tw-shadow: 0px 1px 10px 0px #02CAAB5B;
        --tw-shadow-colored: 0px 1px 10px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-btnShadow3 {
        --tw-shadow: 0px 1px 8px 0px #035ECF82;
        --tw-shadow-colored: 0px 1px 8px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-lg {
        --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-pBar1 {
        --tw-shadow: 2px 1px 4px 0px #1065D0D8;
        --tw-shadow-colored: 2px 1px 4px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-pBar2 {
        --tw-shadow: 2px 1px 4px 0px #AE27015C;
        --tw-shadow-colored: 2px 1px 4px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-pBar3 {
        --tw-shadow: 2px 1px 4px 0px #777777B8;
        --tw-shadow-colored: 2px 1px 4px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-pBar4 {
        --tw-shadow: 2px 1px 4px 0px #AE9E0185;
        --tw-shadow-colored: 2px 1px 4px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-pageBtn {
        --tw-shadow: 0px 1px 6px 0px #035ECF48;
        --tw-shadow-colored: 0px 1px 6px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .shadow-sideShadow {
        --tw-shadow: 0px 3px 14px 0px rgba(226, 225, 225, 0.7672);
        --tw-shadow-colored: 0px 3px 14px 0px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    }

    .outline-none {
        outline: 2px solid transparent;
        outline-offset: 2px;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .transition-colors {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .transition-transform {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }

    .delay-150 {
        transition-delay: 150ms;
    }

    .ease-linear {
        transition-timing-function: linear;
    }

    .customOverlay {
        background: #19203862;
    }

    .customModal {
        border-radius: 6px;
        padding: 0;
        width: 60%;
    }

    ::-webkit-scrollbar {
        width: 1px;
        display: none;
    }

    .placeholder\:text-\[\#1B1B1B\]::-moz-placeholder {
        --tw-text-opacity: 1;
        color: rgb(27 27 27 / var(--tw-text-opacity));
    }

    .placeholder\:text-\[\#1B1B1B\]::placeholder {
        --tw-text-opacity: 1;
        color: rgb(27 27 27 / var(--tw-text-opacity));
    }

    .placeholder\:text-textBluish::-moz-placeholder {
        --tw-text-opacity: 1;
        color: rgb(34 43 69 / var(--tw-text-opacity));
    }

    .placeholder\:text-textBluish::placeholder {
        --tw-text-opacity: 1;
        color: rgb(34 43 69 / var(--tw-text-opacity));
    }

    .last\:border-t:last-child {
        border-top-width: 1px;
    }

    .last\:border-none:last-child {
        border-style: none;
    }

    .last\:py-4:last-child {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .odd\:bg-greyBg:nth-child(odd) {
        --tw-bg-opacity: 1;
        background-color: rgb(249 249 249 / var(--tw-bg-opacity));
    }

    .even\:bg-white:nth-child(even) {
        --tw-bg-opacity: 1;
        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
    }

    .hover\:border-borderColor:hover {
        --tw-border-opacity: 1;
        border-color: rgb(241 241 241 / var(--tw-border-opacity));
    }

    .hover\:border-transparent:hover {
        border-color: transparent;
    }

    .hover\:bg-greyBg:hover {
        --tw-bg-opacity: 1;
        background-color: rgb(249 249 249 / var(--tw-bg-opacity));
    }

    :is([dir="rtl"] .rtl\:text-right) {
        text-align: right;
    }

    @media (min-width: 640px) {

        .sm\:static {
            position: static;
        }

        .sm\:left-\[53\%\] {
            left: 53%;
        }

        .sm\:right-0 {
            right: 0px;
        }

        .sm\:right-\[22\%\] {
            right: 22%;
        }

        .sm\:top-16 {
            top: 4rem;
        }

        .sm\:top-24 {
            top: 6rem;
        }

        .sm\:block {
            display: block;
        }

        .sm\:flex {
            display: flex;
        }

        .sm\:hidden {
            display: none;
        }

        .sm\:h-auto {
            height: auto;
        }

        .sm\:max-h-\[50vh\] {
            max-height: 50vh;
        }

        .sm\:min-h-full {
            min-height: 100%;
        }

        .sm\:w-\[191px\] {
            width: 191px;
        }

        .sm\:w-\[218px\] {
            width: 218px;
        }

        .sm\:w-\[266px\] {
            width: 266px;
        }

        .sm\:w-\[312px\] {
            width: 312px;
        }

        .sm\:w-\[320px\] {
            width: 320px;
        }

        .sm\:w-\[342px\] {
            width: 342px;
        }

        .sm\:w-\[35\%\] {
            width: 35%;
        }

        .sm\:w-\[47\%\] {
            width: 47%;
        }

        .sm\:w-\[48\%\] {
            width: 48%;
        }

        .sm\:w-\[55\%\] {
            width: 55%;
        }

        .sm\:w-\[63\%\] {
            width: 63%;
        }

        .sm\:w-auto {
            width: auto;
        }

        .sm\:flex-row {
            flex-direction: row;
        }

        .sm\:flex-col {
            flex-direction: column;
        }

        .sm\:items-center {
            align-items: center;
        }

        .sm\:rounded-none {
            border-radius: 0px;
        }

        .sm\:bg-transparent {
            background-color: transparent;
        }

        .sm\:px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .sm\:px-8 {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .sm\:py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .sm\:py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .sm\:pr-4 {
            padding-right: 1rem;
        }

        .sm\:text-right {
            text-align: right;
        }

        .sm\:shadow-none {
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }
    }

    @media (min-width: 1024px) {

        .lg\:static {
            position: static;
        }

        .lg\:hidden {
            display: none;
        }

        .lg\:w-0 {
            width: 0px;
        }

        .lg\:w-\[80\%\] {
            width: 80%;
        }

        .lg\:w-auto {
            width: auto;
        }

        .lg\:translate-x-0 {
            --tw-translate-x: 0px;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .lg\:flex-row {
            flex-direction: row;
        }

        .lg\:px-10 {
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }

        .lg\:px-14 {
            padding-left: 3.5rem;
            padding-right: 3.5rem;
        }

        .lg\:py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .lg\:pt-10 {
            padding-top: 2.5rem;
        }

        .lg\:pt-12 {
            padding-top: 3rem;
        }
    }

    @media (min-width: 1280px) {

        .xl\:w-\[166px\] {
            width: 166px;
        }

        .xl\:w-\[218px\] {
            width: 218px;
        }

        .xl\:w-\[35\%\] {
            width: 35%;
        }

        .xl\:w-\[40\%\] {
            width: 40%;
        }

        .xl\:w-\[49\%\] {
            width: 49%;
        }

        .xl\:w-\[65\%\] {
            width: 65%;
        }

        .xl\:w-auto {
            width: auto;
        }

        .xl\:flex-row {
            flex-direction: row;
        }

        .xl\:flex-col {
            flex-direction: column;
        }

        .xl\:justify-between {
            justify-content: space-between;
        }

        .xl\:gap-8 {
            gap: 2rem;
        }

        .xl\:gap-x-4 {
            -moz-column-gap: 1rem;
            column-gap: 1rem;
        }

        .xl\:gap-x-6 {
            -moz-column-gap: 1.5rem;
            column-gap: 1.5rem;
        }

        .xl\:px-10 {
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }

        .xl\:py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .xl\:pt-8 {
            padding-top: 2rem;
        }

        .xl\:text-\[38px\] {
            font-size: 38px;
        }
    }

    @media (min-width: 1536px) {

        .\32xl\:h-\[270px\] {
            height: 270px;
        }

        .\32xl\:max-h-\[64vh\] {
            max-height: 64vh;
        }

        .\32xl\:w-\[163px\] {
            width: 163px;
        }

        .\32xl\:w-\[218px\] {
            width: 218px;
        }

        .\32xl\:w-\[22\%\] {
            width: 22%;
        }

        .\32xl\:w-\[31\%\] {
            width: 31%;
        }

        .\32xl\:w-\[320px\] {
            width: 320px;
        }

        .\32xl\:w-\[374px\] {
            width: 374px;
        }

        .\32xl\:w-\[60\%\] {
            width: 60%;
        }

        .\32xl\:w-\[66\%\] {
            width: 66%;
        }

        .\32xl\:w-\[70\%\] {
            width: 70%;
        }

        .\32xl\:w-\[76\%\] {
            width: 76%;
        }

        .\32xl\:w-\[80\%\] {
            width: 80%;
        }

        .\32xl\:w-auto {
            width: auto;
        }

        .\32xl\:flex-row {
            flex-direction: row;
        }

        .\32xl\:gap-x-11 {
            -moz-column-gap: 2.75rem;
            column-gap: 2.75rem;
        }

        .\32xl\:gap-x-14 {
            -moz-column-gap: 3.5rem;
            column-gap: 3.5rem;
        }

        .\32xl\:gap-x-6 {
            -moz-column-gap: 1.5rem;
            column-gap: 1.5rem;
        }
    }
    </style>
</head>

<body>
    @include('toast')
    <div id="root">
        <div class="flex items-center justify-center w-full h-screen">
            <div class=" bg-greyBg w-[53%] h-full sm:flex hidden flex-col items-center justify-center"><img
                    src="{{asset('admin/login/logo.png')}}" alt="Carsilla Logo"></div>
            <div class="sm:w-[47%] w-full">
                <form class="lg:w-[80%] w-full mx-auto text-center" action="{{ route('admlogin') }}" method="POST">
                    @csrf <h1 class="font-sourceSans font-normal text-[2.38rem] text-textDark">Welcome back!</h1>
                    <p class=" font-roboto text-sm text-textLight 2xl:w-[70%] w-[90%] mx-auto py-1">Carsilla offers
                        complete auto care for your vehicle. Whether it’s time for your next factory recommended
                        maintenance visit, a routine oil change, new tires, or repair services</p>
                    <div class="text-left px-6 font-archivo py-3 2xl:w-[80%] w-full mx-auto">
                        <div class="mb-5"><label for="email"
                                class="block pb-2 text-xs font-bold text-textGrey">Email</label><input type="email"
                                id="email" name="loginemail"
                                class="text-base text-textGrey rounded-lg block w-full py-2 px-4 border-[1px] border-bGrey outline-none"
                                placeholder="example@gmail.com" required=""></div>
                        <div class="mb-5"><label for="password"
                                class="block pb-2 text-xs font-bold text-textGrey">Password</label><input
                                type="password" id="password" name="loginpassword"
                                class="text-base text-textGrey rounded-lg block w-full py-2 px-4 border-[1px] border-bGrey outline-none"
                                placeholder="Enter Your Password (6 characters)" required=""></div>
                        <div class="buttons font-openSans font-semibold flex flex-col xl:gap-8 gap-3"><a
                                href="http://localhost:5173/">
                                <h3 class="text-sm text-center text-textBlue">Forgot Password?</h3>
                            </a>
                            <button type="submit" class="w-full bg-primary rounded-full py-3 text-white text-base"
                                style="background:#790000 !important">Login</button>

                        </div>
                        <div class="relative xl:py-8 py-4 font-archivo">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-b border-bGrey"></div>
                            </div>
                            <div class="relative flex justify-center"><span class="bg-white px-4 text-base">or</span>
                            </div>
                        </div>
                        <div class="w-full flex items-center justify-between font-openSans font-bold text-sm"><a
                                class="w-[48%]" href="http://localhost:5173/"><button
                                    class="flex items-center justify-center gap-4 py-2.5 border border-textBlue rounded-full w-full"><svg
                                        stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" x="0px"
                                        y="0px" viewBox="0 0 48 48" enable-background="new 0 0 48 48"
                                        class="text-[1.4rem]" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12
	c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24
	c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657
	C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36
	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571
	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                                        </path>
                                    </svg>
                                    <p>Google</p>
                                </button></a><a class="w-[48%]" href="http://localhost:5173/"><button
                                    class="flex items-center justify-center gap-4 py-2.5 border border-textBlue rounded-full w-full"><svg
                                        stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                        class="text-[1.4rem] text-textBlue" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z">
                                        </path>
                                    </svg>
                                    <p>Facebook</p>
                                </button></a></div>
                        <p class="xl:pt-8 pt-3 text-center text-sm text-textMd">Don’t You have an account? <a
                                class="font-openSans font-semibold text-textBlue" href="http://localhost:5173/">Sign
                                Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="./Carsillalogin_files/main.jsx"></script>


</body>

</html>