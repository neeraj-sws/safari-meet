# How to Build a SOLID Laravel / Livewire Project

_Practical guidance from a Principal Software Architect_

---

## 1. What SOLID Means in REAL Laravel Projects
- **Single Responsibility:** Every class/file has one reason to change. A Livewire component renders/coordinates UI; it shouldn’t own pricing rules.
- **Open/Closed:** Add new behaviors by extension, not edits everywhere. Example: add a new payment method via a strategy/service, not by stuffing `if/else` in controllers/components.
- **Liskov Substitution:** If you swap an implementation (e.g., `PaymentGatewayInterface` → Razorpay/Stripe), the caller shouldn’t break. Keep contracts stable; implementations vary.
- **Interface Segregation:** Small, focused interfaces beat “god” interfaces. Don’t force services to implement methods they don’t need (e.g., separate `NotifiesUser` from `NotifiesAdmin`).
- **Dependency Inversion:** Depend on abstractions (contracts), not concretes. Inject services into components; bind implementations in service providers.

**Applied to Laravel + Livewire:**
- Livewire components = orchestration + presentation, not business rules.
- Services/Actions = business rules and policies.
- Form Requests = validation rules + basic authorization, not persistence.
- Models = persistence + small domain helpers, not workflows.
- Events/Listeners/Jobs = side-effects (emails, logs, async work).

---

## 2. Thinking in FEATURES, not FILES
- Start from **user flows**, not controllers. Define the path: _List → Detail → Action → Result_.
- Sketch UI states first: loading, empty, success, error, disabled.
- Let **UX drive boundaries**: one feature folder per flow (e.g., `Feature/Orders/List`, `Feature/Orders/Detail`).
- Only then map to Laravel pieces: routes → Livewire component → service calls → events.

---

## 3. Responsibility Breakdown (MOST IMPORTANT)

### Livewire Components
- **Should do:** Render UI state; collect input; call services; show messages; emit events.
- **Must NOT do:** Heavy queries inline; business rules (pricing, eligibility); multi-step transactions; email sending.
- **Typical mistakes:** Fat `render()` with joins; validation mixed with persistence; calling external APIs directly.

### Form Requests
- **When:** HTTP endpoints or Livewire form objects needing structured validation/authorization.
- **Belongs here:** Rules, messages, authorize checks; simple data normalization.
- **Never here:** Business decisions (e.g., discount calculation), DB writes, external API calls.

### Services (a.k.a. Actions/Use Cases)
- **Business logic:** Rules that express “how the business works” (pricing, eligibility, workflows, status transitions).
- **Identify by:** Sentences like “When X happens, we must also do Y unless Z.”
- **Examples:** `CreateOrder`, `AssignGuideToSafari`, `CalculateRefund`, `CompletePackageWorkflow`.

### Models
- **Belongs:** Persistence, relations, small invariants (accessors/mutators), narrow domain helpers (`$booking->isOverdue()` if it’s just date math).
- **Does NOT belong:** Email sending, HTTP calls, cross-aggregate workflows, complex conditionals spanning many entities.

### Repositories (Optional)
- **Use when:** Multiple data sources or swapping storage (DB vs API) is real; or complex query reuse with clear contracts.
- **Avoid when:** You only wrap Eloquent with `findById`/`save`—that’s noise. Prefer query scopes and services instead.

---

## 4. SOLID Principles Applied Practically
- **SRP mistake:** Livewire component saves order, sends email, logs audit. **Problem:** Any change touches UI file; tests brittle. **Fix:** Component calls `PlaceOrderService`, which triggers events; listeners handle email/audit.
- **OCP mistake:** `if ($gateway === 'x') else if ('y')` in component. **Problem:** Every new gateway edits UI file. **Fix:** `PaymentGatewayInterface`; bind implementations; select via factory/config.
- **LSP mistake:** New `PaymentGateway` throws for methods it “doesn’t support.” **Problem:** Callers break. **Fix:** Keep contracts minimal; split interfaces.
- **ISP mistake:** One `NotificationInterface` with 10 methods. **Problem:** Implementers stub half. **Fix:** Multiple small interfaces: `SendsEmail`, `SendsSMS`.
- **DIP mistake:** Component `new StripeClient()` directly. **Problem:** Hard to mock; swap is painful. **Fix:** Inject abstraction; bind in provider; pass config via env.

---

## 5. Common Architectural Mistakes to Avoid
- Fat Livewire components doing queries + business rules.
- Queries inside Blade/Livewire loops instead of preloading.
- Validation + business logic + DB writes in one place.
- Tight coupling: components knowing DB schema details or API payload shapes.
- Hidden side-effects in models (sending emails in `booted`).

---

## 6. Reusable vs Non-Reusable Logic
- **Reusable:** Cross-cutting rules (money, dates, formatting), integrations (email/SMS), generic policies (rate limits), shared UI fragments (toasts, pagination params).
- **Feature-specific:** Workflow steps, eligibility rules, copy/text, feature flags.
- **When abstraction hurts:** Creating generic “Manager” classes with optional params; premature base classes; overusing traits for unrelated concerns.

---

## 7. How SOLID Improves Testing
- **Easier unit tests:** Services with clear inputs/outputs; small helpers; pure functions for calculations.
- **Feature tests focus:** Livewire components + HTTP endpoints verifying flows, not internals.
- **Mocking surfaces:** Interfaces for gateways, not concretes; events for side-effects; jobs for async paths.

---

## 8. Step-by-Step Approach for New Projects
1) **Planning:** Map user journeys (List → Detail → Action → Result). Identify entities, invariants, side-effects.
2) **First implementation:** Build thin Livewire component + service + events. Keep models lean; validate via Form Request/Livewire rules.
3) **Refactor timing:** When a component grows, extract services; when rules repeat, centralize in service/policy; when IO grows, introduce interfaces.
4) **Grow safely:** Add features by adding services/handlers, not editing core flows; keep contracts stable; add tests for new rules.

---

## 9. Senior Developer Guidelines
- If you feel confused, **pause and redesign**; clarity beats cleverness.
- Keep UI thin, services thick (with rules), models lean.
- Prefer explicit over “magic.” Future you will say thanks.
- Add indirection only when a real variability exists (new gateway, new notifier, new data source).
- Don’t let one file own more than one responsibility; SRP is the cheapest insurance.
- SOLID is about **future change**: make the likely changes cheap, and unlikely changes isolated.

---

_Read this as a living mentor note: start with user flows, keep responsibilities sharp, and let SOLID guide your boundaries so you can scale without rewrites._
