import { useForm } from '@inertiajs/vue3';

const getCsrfToken = (): string => {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta?.getAttribute('content') || '';
};

export function useFormWithCsrf<T extends Record<string, any>>(initialData: T) {
    const form = useForm({
        ...initialData,
        _token: getCsrfToken()
    });

    const originalTransform = form.transform;

    form.transform = (callback) => {
        return originalTransform.call(form, (data) => {
            const transformedData = callback(data);
            return {
                ...transformedData,
                _token: getCsrfToken()
            };
        });
    };

    return form;
}
