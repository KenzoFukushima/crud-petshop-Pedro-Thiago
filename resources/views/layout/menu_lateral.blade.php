
        <div class="bg-primary text-white p-3 vh-100 border-end" style="width: 240px; position: fixed;">

            <div class="text-center mb-5">

                <h4>
                    <i class="fas fa-paw"></i>
                    PETSHOP
                </h4>

                <small class="text-secondary">
                    SYSTEM
                </small>

            </div>


            <div class="d-grid gap-2">

                <a href="{{ route('dashboard') }}" class="btn btn-primary text-start text-white">

                    <i class="fas fa-home me-2"></i>
                    Dashboard

                </a>


                <a href="{{ route('telaListaDono') }}" class="btn btn-primary text-start text-white">

                    <i class="fas fa-users me-2"></i>
                    Donos

                </a>


                <a href="{{ route('telaListaPet') }}" class="btn btn-primary text-start text-white">

                    <i class="fas fa-paw me-2"></i>
                    Pets

                </a>


                <a href="{{ route('telaListaServico') }}" class="btn btn-primary text-start text-white">

                    <i class="fas fa-scissors me-2"></i>
                    Serviços

                </a>


                <a href="{{ route('telaListaAgendamento') }}" class="btn btn-primary text-start text-white">

                    <i class="fas fa-calendar-check me-2"></i>
                    Agendamentos

                </a>

            </div>


            <div class="position-absolute bottom-0 start-0 p-3" style="width: 240px;">

                <a href="{{ route('logout') }}" class="btn btn-danger text-start w-100 texto-red">

                    <i class="fas fa-sign-out-alt me-2"></i>
                    Sair

                </a>

            </div>

        </div>