# myKitchen – UI Contract

> **Purpose**: Enforce visual consistency between Owner Panel and User Panel.
> This file is the *only* reference any page or agent should follow.

---

## 1. Colors

* **Primary color**: Yellow-400 (`bg-yellow-400`, `text-yellow-400`)
* **Hover primary**: Yellow-500
* **Text**: Gray-900 (main), Gray-700 (secondary), Gray-500 (muted)
* **Backgrounds**: White cards on Gray-100 pages

**Status colors**:

* Success → Green
* Warning / Pending → Yellow
* Info / In progress → Blue
* Error / Cancelled → Red
* Delivered → Purple

❌ No new primary colors allowed.

---

## 2. Layout & Spacing

* Card-based layout everywhere
* Page sections use `space-y-6`
* Grids use `gap-6`
* Card padding:

  * Normal cards: `p-6`
  * Small cards: `p-4`

---

## 3. Typography

* Font: `Figtree` (fallback: Inter)
* Sizes:

  * Labels: `text-xs`
  * Body & inputs: `text-sm`
  * Card titles: `text-lg`
  * Page titles / modals: `text-2xl`
* Headings are **bold**

❌ No decorative or custom fonts.

---

## 4. Border Radius

* Cards & modals: `rounded-3xl` or `rounded-4xl`
* Inputs: `rounded-xl`
* Badges: `rounded-md` or `rounded-full`
* **All buttons**: `rounded-full`

❌ No sharp corners.

---

## 5. Shadows

* Cards: `shadow-sm` → `hover:shadow-xl`
* Buttons: `shadow-sm` or `shadow-lg`
* Modals: `shadow-2xl`

---

## 6. Buttons

* One **Primary Button** style only (yellow)
* Buttons are pill-shaped
* Icons + text allowed
* Full-width on mobile

❌ No new button styles without approval.

---

## 7. Cards

* White background
* Rounded corners
* Subtle border or shadow
* Hover effects allowed (lift / shadow)

All pages must reuse existing card patterns.

---

## 8. Forms & Inputs

* Inputs: rounded-xl
* Yellow focus state
* Clear error state (red text + icon)

---

## 9. Modals

* Rounded containers
* Yellow → Orange gradient header
* Sizes:

  * Small: `max-w-lg`
  * Large: `max-w-2xl`

---

## 10. Animations

* Use subtle transitions only
* Duration: ~300ms
* Hover effects allowed (scale, lift, shadow)

❌ No heavy or distracting animations.

---

## 11. Icons

* Single icon style (Heroicons)
* Default size: `size-5`
* Icons always aligned with text

---

## Global Rules (Most Important)

1. Reuse existing components only
2. No new layouts, colors, or UI patterns
3. If unsure → copy an existing Owner Panel page
4. Consistency > creativity

---

**If a page visually looks different, it is wrong – even if it works.**
